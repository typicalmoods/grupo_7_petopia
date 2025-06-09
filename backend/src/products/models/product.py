from database import db

class Product(db.Model):
    __tablename__ = "products"

    id = db.Column(db.Integer, primary_key=True)
    name = db.Column(db.String(255), nullable=False)
    description = db.Column(db.String(510))
    animal_species = db.Column(db.String(50))
    brand = db.Column(db.String(50), nullable=False)
    stock = db.Column(db.Integer, nullable=False)
    price = db.Column(db.Numeric(16, 2), nullable=False)
    discount = db.Column(db.Numeric(16, 2), nullable=False)
    category = db.Column(db.String(50), nullable=False)

    def to_dict(self):
        return {
            "id": self.id,
            "name": self.name,
            "description": self.description,
            "animal_species": self.animal_species,
            "brand": self.brand,
            "stock": self.stock,
            "price": str(self.price),
            "discount": str(self.discount),
            "category": self.category,
        }

    @staticmethod
    def get_by_id(product_id):
        return db.session.query(Product).filter_by(id=product_id).first()
    
    @staticmethod
    def get_all():
        return db.session.query(Product).all()
