from database import db
from flask import Blueprint, jsonify, request, session
from http import HTTPStatus
from users.models.user import User
import bcrypt

user_bp = Blueprint('user_bp', __name__, url_prefix='/api/v1/users')


@user_bp.route('/register', methods=['POST'])
def register():
    request_data = request.json
    username = request_data.get("username")
    password = request_data.get("password")
    email = request_data.get("email")
    phone = request_data.get("phone")
    address = request_data.get("address")
    birthdate = request_data.get("birthdate")
    
    missing_fields = [key for key in ["username", "password", "email", "phone", "address", "birthdate"] if not request_data.get(key)]
    if missing_fields:
        return jsonify({"message": f"Missing fields: {', '.join(missing_fields)}"}), HTTPStatus.BAD_REQUEST

    try:
        if not valid_unique_fields(username, email, phone):
            return jsonify({"message": "Username, email, or phone already exists"}), HTTPStatus.BAD_REQUEST
        
        hashed_password = encrypt_password(password)
        user = User.create(username, hashed_password, email, phone, address, birthdate)
        return jsonify({"message": "User registered successfully", "user": user.to_dict()}), HTTPStatus.CREATED
    except Exception as error:
        db.session.rollback()
        return jsonify({"message": f"Database error: {error}"}), HTTPStatus.INTERNAL_SERVER_ERROR


@user_bp.route('/login', methods=['POST'])
def login():
    request_data = request.json
    username = request_data.get("username")
    password = request_data.get("password")

    if not username or not password:
        return jsonify({"message": "Username and password are required"}), HTTPStatus.BAD_REQUEST

    user = User.get_by_username(username)

    if not user or not bcrypt.checkpw(password.encode("utf-8"), user.password.encode("utf-8")):
        return jsonify({"message": "Invalid username or password"}), HTTPStatus.UNAUTHORIZED

    session["user_id"] = user.id
    return jsonify({"message": "Successfully logged in"}), HTTPStatus.OK


@user_bp.route('/logout', methods=['POST'])
def logout():
    session.pop("user_id", None)
    return jsonify({"message": "Successfully logged out"}), HTTPStatus.OK


@user_bp.route('/<int:id>', methods=['PATCH'])
def update(id):
    if "user_id" not in session:
        return jsonify({"message": "Unauthorized"}), HTTPStatus.UNAUTHORIZED
    if session["user_id"] != id:
        return jsonify({"message": "Forbidden: You can only update your own account"}), HTTPStatus.FORBIDDEN

    request_data = request.json

    try:
        user = User.get_by_id(id)
        if not user:
            return jsonify({"message": "User not found"}), HTTPStatus.NOT_FOUND
        
        if not valid_unique_fields(request_data.get("username"), request_data.get("email"), request_data.get("phone")):
            return jsonify({"message": "Username, email, or phone already exists"}), HTTPStatus.BAD_REQUEST

        if "password" in request_data and request_data["password"]:
            request_data["password"] = encrypt_password(request_data["password"])

        updated_user = User.update(user, **request_data)
        return jsonify({"message": "User updated successfully", "user": updated_user.to_dict()}), HTTPStatus.OK
    except Exception as error:
        db.session.rollback()
        return jsonify({"message": f"Database error: {error}"}), HTTPStatus.INTERNAL_SERVER_ERROR


def encrypt_password(password):
    return bcrypt.hashpw(password.encode("utf-8"), bcrypt.gensalt()).decode("utf-8")


def valid_unique_fields(username=None, email=None, phone=None):
    if username and User.username_exists(username):
        return False
    if email and User.email_exists(email):
        return False
    if phone and User.phone_exists(phone):
        return False
    return True
