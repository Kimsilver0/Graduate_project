from flask import Flask, request, jsonify
import innoturn_bot  # 챗봇 코드가 포함된 모듈

app = Flask(__name__)

@app.route('/chat', methods=['POST'])
def chat():
    user_input = request.json['user_input']
    response = innoturn_bot.respond(user_input)
    return jsonify(response=response)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)