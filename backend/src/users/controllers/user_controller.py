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
        if User.exists(username):
            return jsonify({"message": "Username already exists"}), HTTPStatus.BAD_REQUEST
        
        hashed_password = bcrypt.hashpw(password.encode("utf-8"), bcrypt.gensalt()).decode("utf-8")
        User.create(username, hashed_password, email, phone, address, birthdate)
        return jsonify({"message": "User registered successfully"}), HTTPStatus.CREATED
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

    user = User.get(username)

    if not user or not bcrypt.checkpw(password.encode("utf-8"), user.password.encode("utf-8")):
        return jsonify({"message": "Invalid username or password"}), HTTPStatus.UNAUTHORIZED

    session["user_id"] = user.id
    return jsonify({"message": "Successfully logged in"}), HTTPStatus.OK


@user_bp.route('/logout', methods=['POST'])
def logout():
    session.pop("user_id", None)
    return jsonify({"message": "Successfully logged out"}), HTTPStatus.OK
