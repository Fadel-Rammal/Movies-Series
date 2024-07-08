from flask import Flask, request, jsonify
from flask_cors import CORS
import google.generativeai as genai

app = Flask(__name__)
CORS(app)  # Enable CORS for all routes

# Configure Google generative AI


GOOGLE_API_KEY = 'paste your api here'


genai.configure(api_key=GOOGLE_API_KEY)

# Initialize generative model
model = genai.GenerativeModel('gemini-pro')

@app.route('/', methods=['GET', 'POST'])
def chat():
    if request.method == 'GET':
        return "Welcome to the chat interface!"  # Provide a message for GET requests
    elif request.method == 'POST':
        user_message = request.json['prompt']
        # Generate AI response
        ai_response = model.generate_content(user_message)
        result = ''.join([p.text for p in ai_response.candidates[0].content.parts])
        return jsonify({'message': result})

if __name__ == '__main__':
    # Run the Flask application on port 5001
    app.run(debug=True, port=5001)
