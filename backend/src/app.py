from config import Config
from database import init_app
from flask import Flask, jsonify
from http import HTTPStatus
from users.controllers import user_bp

app = Flask(__name__)
init_app(app)

# Secret key for session management
app.secret_key = Config.ENCRYPT_SECRET_KEY

app.register_blueprint(user_bp)


@app.route("/health", methods=["GET"])
def health_check():
    return jsonify({"status": "ok"}), HTTPStatus.OK


if __name__ == "__main__":
    app.run(host="0.0.0.0", port=Config.APP_PORT)
