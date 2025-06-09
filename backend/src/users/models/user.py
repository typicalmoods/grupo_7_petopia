from database import db

class User(db.Model):
    __tablename__ = "users"

    id = db.Column(db.Integer, primary_key=True)
    username = db.Column(db.String(50), unique=True, nullable=False)
    password = db.Column(db.String(255), nullable=False)
    email = db.Column(db.String(255), unique=True, nullable=False)
    phone = db.Column(db.String(20), unique=True, nullable=False)
    address = db.Column(db.String(255), nullable=False)
    birthdate = db.Column(db.Date, nullable=False)

    def to_dict(self):
        return {
            "id": self.id,
            "username": self.username,
            "email": self.email,
            "phone": self.phone,
            "address": self.address,
            "birthdate": str(self.birthdate),
        }

    @staticmethod
    def get_by_id(user_id):
        return db.session.query(User).filter_by(id=user_id).first()

    @staticmethod
    def get_by_username(username):
        return db.session.query(User).filter_by(username=username).first()
    
    @staticmethod
    def username_exists(username):
        return db.session.query(User).filter_by(username=username).first() is not None
    
    @staticmethod
    def email_exists(email):
        return db.session.query(User).filter_by(email=email).first() is not None
    
    @staticmethod
    def phone_exists(phone):
        return db.session.query(User).filter_by(phone=phone).first() is not None
    
    @staticmethod
    def create(username, hashed_password, email=None, phone=None, address=None, birthdate=None):
        new_user = User(
            username=username,
            password=hashed_password, 
            email=email, phone=phone, 
            address=address, 
            birthdate=birthdate    
        )
        db.session.add(new_user)
        db.session.commit()
        return new_user

    @staticmethod
    def update(user, **kwargs):
        if user:
            for field, value in kwargs.items():
                if hasattr(user, field) and value:
                    setattr(user, field, value)
            db.session.commit()
        return user
