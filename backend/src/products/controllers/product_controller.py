from flask import Blueprint, jsonify
from http import HTTPStatus
from products.models.product import Product

product_bp = Blueprint('product_bp', __name__, url_prefix='/api/v1/products')


@product_bp.route('/<int:product_id>', methods=['GET'])
def get_product(product_id):
    product = Product.get_by_id(product_id)
    if product:
        return jsonify(product.to_dict()), HTTPStatus.OK
    return jsonify({"error": "Product not found"}), HTTPStatus.NOT_FOUND


@product_bp.route('/', methods=['GET'])
def get_all_products():
    products = Product.get_all()
    return jsonify([product.to_dict() for product in products]), HTTPStatus.OK
