from database import db

class Cart(db.Model):
    __tablename__ = "carts"

    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, nullable=False)
    product_id = db.Column(db.Integer, nullable=False)
    quantity = db.Column(db.Integer, nullable=False)
    status = db.Column(db.String(20), nullable=False, default='ACTIVE')
    created_at = db.Column(db.DateTime, default=db.func.current_timestamp())

    def to_dict(self):
       return {
            "id": self.id,
            "user_id": self.user_id,
            "product_id": self.product_id,
            "quantity": self.quantity,
            "status": self.status,
            "created_at": self.created_at.isoformat() if self.created_at else None
       }

    @staticmethod
    def get_by_id(cart_id):
        return db.session.query(Cart).filter_by(id=cart_id).first()
    
    @staticmethod
    def get_all_by_user_id(user_id):
        return db.session.query(Cart).filter_by(user_id=user_id).all()
    
    @staticmethod
    def create(user_id, product_id, quantity):
        new_cart = Cart(
            user_id=user_id,
            product_id=product_id,
            quantity=quantity
        )
        db.session.add(new_cart)
        db.session.commit()
        return new_cart
    
    @staticmethod
    def update_status(cart, status):
        if cart:
            cart.status = status
            db.session.commit()
        return cart
