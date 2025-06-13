from database import db
from flask import Blueprint, jsonify, request, session
from http import HTTPStatus
from carts.models.cart import Cart
import logging

cart_bp = Blueprint('cart_bp', __name__, url_prefix='/api/v1/carts')


@cart_bp.route('/<int:cart_id>', methods=['GET'])
def get_cart(cart_id):
    if "user_id" not in session:
        return jsonify({"message": "Unauthorized"}), HTTPStatus.UNAUTHORIZED
        
    cart = Cart.get_by_id(cart_id)
    if cart and cart.user_id != session["user_id"]:
        return jsonify({"message": "Forbidden: You can only access your own cart"}), HTTPStatus.FORBIDDEN
    if cart.user_id == session["user_id"]:
        return jsonify(cart.to_dict()), HTTPStatus.OK
    return jsonify({"error": "Cart not found"}), HTTPStatus.NOT_FOUND


@cart_bp.route('/', methods=['GET'])
def get_all_carts():
    if "user_id" not in session:
        return jsonify({"message": "Unauthorized"}), HTTPStatus.UNAUTHORIZED
        
    carts = Cart.get_all_by_user_id(session["user_id"])
    return jsonify([cart.to_dict() for cart in carts]), HTTPStatus.OK


@cart_bp.route('/', methods=['POST'])
def create_carts():
    if "user_id" not in session:
        return jsonify({"message": "Unauthorized"}), HTTPStatus.UNAUTHORIZED

    request_data = request.get_json()
    user_id = session["user_id"]
    products = request_data.get('products')
    
    logging.debug(f"Creating carts for user_id: {user_id} with products: {products}")

    if not products:
        return jsonify({"error": "Missing required fields"}), HTTPStatus.BAD_REQUEST

    created_carts = []
    for product in products:
        product_id = product.get('product_id')
        quantity = product.get('quantity')

        if not product_id or not quantity:
            db.session.rollback()
            return jsonify({"error": "Each product must have a product_id and quantity"}), HTTPStatus.BAD_REQUEST

        if quantity <= 0:
            db.session.rollback()
            return jsonify({"error": "Quantity must be a positive number"}), HTTPStatus.BAD_REQUEST

        new_cart = Cart.create(user_id, product_id, quantity)
        created_carts.append(new_cart.to_dict())

    return jsonify(created_carts), HTTPStatus.CREATED
