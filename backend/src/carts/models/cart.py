from database import db

class Cart(db.Model):
    __tablename__ = "carts"

    id = db.Column(db.Integer, primary_key=True)
    user_id = db.Column(db.Integer, nullable=False)
    product_id = db.Column(db.Integer, nullable=False)
    quantity = db.Column(db.Integer, nullable=False)

    def to_dict(self):
       return {
            "id": self.id,
            "user_id": self.user_id,
            "product_id": self.product_id,
            "quantity": self.quantity,
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
