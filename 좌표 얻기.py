# 필요한 라이브러리 가져오기
import cv2

# 미리 훈련된 모델 경로 설정
model_path = 'C:/yolov5-master/yolov5-master/runs/train/tables'  # 사용할 미리 훈련된 모델의 경로를 지정해야 합니다.

# 미리 훈련된 모델을 로드하여 네트워크 설정
net = cv2.dnn.readNetFromTensorflow(model_path)

# 동영상 불러오기
video = cv2.VideoCapture('그라찌에_1.mov')  # 동영상 파일명을 적절히 변경하세요.

# 객체 감지 및 추적
while True:
    success, frame = video.read()
    if not success:
        break

    # 프레임에서 객체 감지하기
    blob = cv2.dnn.blobFromImage(frame, size=(300, 300), swapRB=True, crop=False)
    net.setInput(blob)
    detections = net.forward()

    for i in range(detections.shape[2]):
        confidence = detections[0, 0, i, 2]
        if confidence > 0.5:  # 일정 신뢰도 이상인 경우 객체로 간주
            class_id = int(detections[0, 0, i, 1])
            if class_id == 1:  # 클래스 ID가 테이블 또는 의자일 경우
                bbox = detections[0, 0, i, 3:7] * np.array([frame.shape[1], frame.shape[0], frame.shape[1], frame.shape[0]])
                x, y, w, h = bbox.astype(int)
                # 여기서 데이터를 저장하거나 원하는 방식으로 활용할 수 있습니다.
