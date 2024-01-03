def greet(bot_name, birth_year):
    print(f"이노턴봇: 안녕하세요, 저는 {bot_name}입니다. 저는 {birth_year}에 이노턴파트너즈에 의해 개발되었습니다.")
    print("이노턴봇: 오늘 무엇을 도와드릴까요?")

def respond(user_input):
    if user_input.lower() == "안녕하세요":
        return "안녕! 오늘 무엇을 도와드릴까요?"
    elif user_input.lower() == "안녕히 계세요":
        return "안녕히 가세요! 좋은 하루 되세요."
    elif user_input.lower() == "당신의 이름은 무엇입니까?":
        return "제 이름은 이노턴봇입니다."
    elif user_input.lower() == "당신의 출생 연도는 무엇입니까?":
        return "저는 2023년에 태어났습니다."
    elif user_input.lower() == "당신은 무엇을 할 수 있나요?":
        return "저는 이노턴파트너즈의 기본적인 업무를 수행할 수 있습니다."
    elif "날씨" in user_input.lower():
        return "현재 날씨는 네이버나 구글에 검색하시면 자세히 나와있습니다."
    else:
        return "죄송합니다. 무슨 말을 하려는지 잘 모르겠습니다. 다시 말씀해 주시겠습니까?"

bot_name = "이노턴봇"
birth_year = 2023
greet(bot_name, birth_year)

while True:
    user_input = input("CUSTOMER: ")
    response = respond(user_input)
    print(f"iNNOTURN: {response}")
    if user_input.lower() == "안녕히 계세요":
        break
