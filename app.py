from flask import Flask, render_template, request
import joblib
import numpy as np
import mysql.connector

app = Flask(__name__)

model = joblib.load("model.pkl")

def connect_db():
    return mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="student_scores"
    )

@app.route('/')
def index():
    return render_template("index.html")

@app.route('/predict', methods=['GET', 'POST'])
def predict():
    if request.method == 'POST':
        name = request.form['name']
        gender = 1 if request.form['gender'] == 'Male' else 0
        hours = float(request.form['hours_studied'])
        previous = float(request.form['previous_score'])
        attendance = int(request.form['attendance'])
        parent = 1 if request.form['parental_involvement'] == 'High' else 0

        features = np.array([[hours, previous, attendance, gender, parent]])
        predicted_score = round(model.predict(features)[0], 2)

        # Save to MySQL
        conn = connect_db()
        cur = conn.cursor()
        cur.execute("""
            INSERT INTO predictions (name, gender, hours_studied, previous_score, attendance, parental_involvement, predicted_score)
            VALUES (%s, %s, %s, %s, %s, %s, %s)
        """, (name, 'Male' if gender == 1 else 'Female', hours, previous, attendance, 'High' if parent == 1 else 'Low', predicted_score))
        conn.commit()
        cur.close()
        conn.close()

        return render_template("result.html", name=name, score=predicted_score)
    return render_template("predict.html")


if __name__ == '__main__':
    print("Starting Flask server...")
    app.run(debug=True)


if __name__ == '__main__':
    print("Starting Flask server...")  # Diagnostic print
    app.run(debug=True)
