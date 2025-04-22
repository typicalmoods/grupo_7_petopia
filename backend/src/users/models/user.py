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
    
    @staticmethod
    def exists(username):
        return db.session.query(User).filter_by(username=username).first() is not None

    @staticmethod
    def get(username):
        return db.session.query(User).filter_by(username=username).first()

    @staticmethod
    def create(username, hashed_password, email=None, phone=None, address=None, birthdate=None):
        new_user = User(username=username, password=hashed_password, email=email, phone=phone, address=address, birthdate=birthdate)
        db.session.add(new_user)
        db.session.commit()
        return new_user
