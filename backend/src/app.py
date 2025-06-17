from config import Config
from database import init_app
from flask import Flask, jsonify
from flask_cors import CORS
from http import HTTPStatus
from users.controllers import user_bp
from products.controllers import product_bp
from carts.controllers import cart_bp
import logging

app = Flask(__name__)
CORS(app, supports_credentials=True)
init_app(app)

# Secret key for session management
app.secret_key = Config.ENCRYPT_SECRET_KEY

app.register_blueprint(user_bp)
app.register_blueprint(product_bp)
app.register_blueprint(cart_bp)


logging.basicConfig(level=logging.DEBUG)

@app.route("/health", methods=["GET"])
def health_check():
    return jsonify({"status": "ok"}), HTTPStatus.OK


if __name__ == "__main__":
    app.run(host="0.0.0.0", port=Config.APP_PORT)
