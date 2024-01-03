// 예약 정보 데이터
const reservationData = {
    // '날짜': 예약된 좌석 수
};

// 현재 날짜 표시 함수
function displayCurrentDate() {
    const now = new Date();
    const currentDate = now.toLocaleDateString();
    document.getElementById('datetime').textContent = currentDate;
}

// 현재 날짜의 예약 가능 시간을 나타내는 함수
function displayCurrentDateReservation() {
    const now = new Date();
    const currentYear = now.getFullYear();
    const currentMonth = now.getMonth();
    const currentDate = now.getDate();

    // 현재 달의 첫 날짜 가져오기
    const firstDay = new Date(currentYear, currentMonth, 1).getDay();

    // 이번 달의 마지막 날짜 가져오기
    const lastDay = new Date(currentYear, currentMonth + 1, 0).getDate();

    // 오늘 날짜를 yyyy-mm-dd 형식으로 변환
    const currentDateString = `${currentYear}-${(currentMonth + 1).toString().padStart(2, '0')}-${currentDate.toString().padStart(2, '0')}`;

    // 달력 생성 함수 호출 시 오늘 날짜와 예약 정보를 전달하여 예약 불가능한 날짜를 표시
    createCalendar(currentYear, currentMonth, currentDate, lastDay, currentDateString);
}

// 달력 그리기가 끝난 후 호출되는 함수
function onCalendarDrawn() {
    // 모든 날짜 요소 가져오기
    const dayElements = document.querySelectorAll('.calendar-day');
    
    // 각 날짜를 클릭했을 때의 동작 설정
    dayElements.forEach(dayElement => {
        dayElement.addEventListener('click', () => {
            const date = dayElement.textContent;
            updateSelectedDate(date);
            // 이 부분에서 timeTableMaker 함수 호출
            timeTableMaker(date); // 선택한 날짜에 따른 시간표 표시
        });
    });
}

// 달력 생성 함수 수정
function createCalendar(year, month, today, lastDay, currentDateString) {
    const calendarGrid = document.getElementById('calendar-grid');
    calendarGrid.innerHTML = '';

    const daysInMonth = lastDay;

    // 요일 배열
    const dayNames = ['일', '월', '화', '수', '목', '금', '토'];

    // 이번 달의 첫 날짜의 요일 인덱스 가져오기
    const firstDayIndex = new Date(year, month, 1).getDay();

    // 첫 날짜를 요일에 맞춰서 표시
    for (let i = 0; i < firstDayIndex; i++) {
        const emptyElement = document.createElement('div');
        emptyElement.classList.add('empty-day');
        calendarGrid.appendChild(emptyElement);
    }

    // 이번 달의 날짜
    for (let i = 1; i <= daysInMonth; i++) {
        const dayElement = document.createElement('div');
        dayElement.classList.add('calendar-day');
        dayElement.textContent = i;

        // 현재 날짜를 yyyy-mm-dd 형식으로 변환
        const currentDate = `${year}-${(month + 1).toString().padStart(2, '0')}-${i.toString().padStart(2, '0')}`;

        // 오늘의 날짜인 경우에만 클릭 가능
        if (currentDate === currentDateString) {
            dayElement.classList.add('clickable');
        }

        // 오늘 날짜와 예약 정보가 있는 경우에만 예약 가능
        if (currentDate !== currentDateString || currentDate in reservationData) {
            dayElement.classList.add('reserved');
            dayElement.setAttribute('title', `예약된 좌석 수: ${reservationData[currentDate]}`);
        }
        calendarGrid.appendChild(dayElement);
    }

    // 달력 그리기가 끝나면 onCalendarDrawn 함수 호출
    onCalendarDrawn();
}

// 클릭한 날짜를 업데이트하는 함수
function updateSelectedDate(date) {
    selectedDate = date;
    const selectedDateElement = document.getElementById('selected-date');
    selectedDateElement.textContent = `${date} 일 Time Slot`; // 선택한 날짜로 제목 설정

    // 시간표 테이블의 caption과 thead를 가져옴
    const caption = document.querySelector('#timeTable caption');
    const thead = document.querySelector('#timeTable thead');

    // caption과 thead를 초기화
    caption.textContent = '';
    thead.innerHTML = '';

    // 시간대 목록 추가 (예: 9:00 AM부터 2:00 PM까지)
    const startTime = 9;
    const endTime = 14; // 14시로 바꾸기 다시

    // 테이블 헤더 생성
    const headerRow = document.createElement('tr');
    const timeHeader = document.createElement('th');
    timeHeader.textContent = '시간대';
    headerRow.appendChild(timeHeader);
    thead.appendChild(headerRow);

    // 시간표 테이블의 tbody 요소를 가져옴
    const tbody = document.getElementById('timeTable').getElementsByTagName('tbody')[0];
}

// 달력 그리기가 끝난 후 호출되는 함수
function onCalendarDrawn() {
    const dayElements = document.querySelectorAll('.calendar-day');

    dayElements.forEach(dayElement => {
        dayElement.addEventListener('click', () => {
            const date = dayElement.textContent;
            updateSelectedDate(date);
            // 이 부분에서 timeTableMaker 함수 호출
            timeTableMaker(selectedDate); // 선택한 날짜에 따른 시간표 표시
        });
    });
}

// 시간표 생성 함수
function timeTableMaker(selectedDate) {
    const timeTableContainer = document.getElementById('timeTableContainer');

    if (!timeTableContainer) {
        const timeTableContainer = document.createElement('div');
        timeTableContainer.id = 'timeTableContainer';
        document.body.appendChild(timeTableContainer);
    }

    const currentTime = new Date(); // 현재 시간 가져오기
    const currentHour = currentTime.getHours(); // 현재 시간의 시간 부분 가져오기
    const currentMinute = currentTime.getMinutes(); // 현재 시간의 분 부분 가져오기

    // main.php에서 받은 예약된 시간
    const userselectedTimeInfo = '<?php echo $userselectedTimeInfo; ?>';

    const startTime = 9;
    const endTime = 23;

    // 현재 시간이 예약 가능한 범위를 벗어나면 예약 불가로 설정
    if (currentHour < startTime || currentHour >= endTime) {
        const timeNotAvailableMessage = document.createElement('p');
        timeNotAvailableMessage.textContent = '현재 예약이 불가능한 시간입니다. 내일 예약을 부탁드립니다!';
        timeTableContainer.appendChild(timeNotAvailableMessage);
        return;
    }

    const times = Array.from({ length: endTime - startTime + 1 }, (_, index) => index + startTime);

    const table = document.createElement('table');
    const tbody = document.createElement('tbody');

    times.forEach(hour => {
        const row = document.createElement('tr');
        const timeCell = document.createElement('td');
        let displayHour = hour; // 시간 표시용 변수

        if (hour >= 12) {
            // 12시 이상인 경우 PM으로 표시
            displayHour = `${hour}:00 PM`;
        } else {
            // 12시 미만인 경우 AM으로 표시
            displayHour = `${hour}:00 AM`;
        }
        timeCell.textContent = displayHour;
        row.appendChild(timeCell);

        const timeSelectionCell = document.createElement('td');
        timeSelectionCell.classList.add('time-selection-box');
        
        // 현재 시간을 지났는지 확인하고 드래그를 막음
        if (currentHour > hour || (currentHour === hour && currentMinute > 0) || userselectedTimeInfo.includes(displayHour)) {
            timeSelectionCell.textContent = '예약 불가';
            timeSelectionCell.classList.add('not-available');
            timeSelectionCell.addEventListener('mousedown', (event) => {
                event.preventDefault(); // 드래그 방지
            });
        } else {
            timeSelectionCell.textContent = '예약 가능';
            timeSelectionCell.addEventListener('mousedown', () => {
                // 드래그 시작 시간 설정
                startSelection(hour);
            });
            timeSelectionCell.addEventListener('mouseup', () => {
                // 드래그 종료 시간 설정
                endSelection(hour);
            });
            timeSelectionCell.addEventListener('mousemove', (event) => {
                // 드래그 이벤트 처리
                handleDragEvent(event, hour);
            });
        }

        row.appendChild(timeSelectionCell);

        tbody.appendChild(row);
    });

    table.appendChild(tbody);
    timeTableContainer.appendChild(table);
}

// 드래그 시작 시간을 저장하는 변수
let startSelectionHour = 0;

// 드래그 시작 시간 설정 함수
function startSelection(hour) {
    startSelectionHour = hour;
}

// 드래그 종료 시간을 저장하는 변수
let endSelectionHour = 0;

// 드래그 종료 시간 설정 함수
function endSelection(hour) {
    endSelectionHour = hour;
    if (startSelectionHour !== 0 && endSelectionHour !== 0) {
        highlightSelectedTime(startSelectionHour, endSelectionHour);
        saveSelectedTime(startSelectionHour, endSelectionHour);
    }
}

// 선택한 시간대를 강조 표시하는 함수
function highlightSelectedTime(startHour, endHour) {
    const timeCells = document.querySelectorAll('.time-selection-box');
    let isHighlighting = false;

    timeCells.forEach(timeCell => {
        const hourText = timeCell.parentNode.firstChild.textContent.split(' ')[0]; // 시간대 텍스트 가져오기
        const hour = parseInt(hourText, 10);

        if (hour === startHour) {
            isHighlighting = true;
            timeCell.classList.add('selected');
        }

        if (isHighlighting) {
            timeCell.classList.add('selected');
        }

        if (hour === endHour) {
            isHighlighting = false;
        }
    });

    // 선택한 시간대를 저장
    storeSelectedTime(startHour, endHour);
}

// 선택한 시간대를 저장하는 함수
function storeSelectedTime(startHour, endHour) {
    // 선택한 시간대를 예약 정보에 추가하거나 다른 곳에 저장
    const selectedTime = `${startHour}:00-${endHour + 1}:00`; // 예약 정보를 저장할 형식으로 시간대 변환
    localStorage.setItem('selectedTime', selectedTime); // 브라우저 로컬 스토리지에 저장

    // 이후 예약 버튼을 누르면 해당 시간대를 서버로 전송하여 예약을 완료할 수 있도록 구현
    const reservationButton = document.getElementById('reservation-button');
    if (reservationButton) {
        reservationButton.addEventListener('click', () => {
            const selectedTimeInfo = localStorage.getItem('selectedTime');
            const currentDate = new Date().toLocaleDateString();
            window.location.href = `reservate_details.php?selectedTime=${selectedTimeInfo}&currentDate=${currentDate}`;
        });
    }
}

// 전역 변수 추가
let isDragging = false;
let isTimeSelected = false; // 선택한 시간이 있는지 여부를 추적하는 변수

// 드래그된 상자에 스타일을 적용하는 함수
function applySelectionStyle(element) {
    element.classList.add('selected');
}

// 드래그 이벤트를 처리하는 함수
function handleDragEvent(event, hour) {
    if (isDragging) {
        const timeCells = document.querySelectorAll('.time-selection-box');
        timeCells.forEach(timeCell => {
            const hourText = timeCell.parentNode.firstChild.textContent.split(' ')[0];
            const cellHour = parseInt(hourText, 10);
            if (cellHour >= startSelectionHour && cellHour <= hour) {
                if (isValidTimeRange(startSelectionHour, hour)) {
                    applySelectionStyle(timeCell);
                } else {
                    clearSelectionStyles();
                }
            }
        });
    }
}

// 예약 가능한 시간 범위를 확인하는 함수
function isValidTimeRange(startHour, endHour) {
    const reservationLimit = 2; // 예약 가능한 최대 시간(2시간)
    return endHour - startHour <= reservationLimit; // 예약 가능 범위인지 확인
}

// 선택한 시간대 스타일을 초기화하는 함수
function clearSelectionStyles() {
    const timeCells = document.querySelectorAll('.time-selection-box');
    timeCells.forEach(timeCell => {
        timeCell.classList.remove('selected');
    });
}

// 드래그된 시간대를 저장하는 배열
let selectedTimeSlots = [];

// 드래그가 끝날 때 선택한 시간대를 저장하는 함수
function endSelection(hour) {
    endSelectionHour = hour;
    if (startSelectionHour !== 0 && endSelectionHour !== 0) {
        highlightSelectedTime(startSelectionHour, endSelectionHour);
        saveSelectedTime(startSelectionHour, endSelectionHour);
        displaySelectedTimeMessage(startSelectionHour, endSelectionHour);
        addReservationButton(); // 예약 정보 확인 버튼 추가
    }
}

// 선택한 시간대를 저장하는 함수
function saveSelectedTime(startHour, endHour) {
    if (isValidTimeRange(startHour, endHour)) {
        selectedTimeSlots.push({ start: startHour, end: endHour });
    } else {
        // 예약 가능한 범위를 초과했을 때 동작 추가
        alert("예약 가능한 시간 범위를 초과했습니다.");
        clearSelectionStyles(); // 선택한 스타일 지우기
    }
}

// 선택한 시간대를 화면에 표시하는 함수
function displaySelectedTimeMessage(startHour, endHour) {
    const timeTableContainer = document.getElementById('timeTableContainer');
    let messageElement = document.getElementById('selected-time-message');

    if (!messageElement) {
        messageElement = document.createElement('div');
        messageElement.id = 'selected-time-message';
        timeTableContainer.appendChild(messageElement);
    }

    if (isValidTimeRange(startHour, endHour)) { // 예약 가능한 범위를 확인
        if (!isTimeSelected) {
            messageElement.textContent = `현재 선택된 시간은 ${startHour}시부터 ${endHour + 1}시 입니다.`;
            isTimeSelected = true;
            addReservationButton(); // 예약 정보 확인 버튼 추가
        } else if (startHour !== startSelectionHour || endHour !== endSelectionHour) {
            messageElement.textContent = `현재 선택된 시간은 ${startHour}시부터 ${endHour + 1}시 입니다.`;
            startSelectionHour = startHour;
            endSelectionHour = endHour;
            removeReservationButton(); // 예약 정보 확인 버튼 제거
            addReservationButton(); // 변경된 시간에 맞게 예약 정보 확인 버튼 다시 추가
        } else {
            // 이미 선택한 시간이 있는 경우에는 알림을 띄우고 선택을 취소하도록 함
            const confirmation = confirm(
                `이미 선택한 시간대가 있습니다. 선택을 취소하고 ${startHour}시부터 ${endHour + 1}시까지 선택하시겠습니까?`
            );
            if (confirmation) {
                clearSelection(); // 선택을 취소하고 다른 시간대 선택
            }
        }
    } else {
        clearSelectionStyles(); // 선택한 스타일 지우기
    }

    // 페이지에 메시지를 나타내도록 요소를 추가
    if (!timeTableContainer.contains(messageElement)) {
        timeTableContainer.appendChild(messageElement);
    }
}

// 선택을 취소하는 함수
function clearSelection() {
    startSelectionHour = 0;
    endSelectionHour = 0;
    isTimeSelected = false;
    clearSelectionStyles(); // 선택한 시간대 스타일 초기화
    document.getElementById('selected-time-message').textContent = ''; // 선택 시간 메세지 초기화
    removeReservationButton(); // 예약 버튼 제거
}

// 예약 정보 확인 버튼을 추가하는 함수
function addReservationButton() {
    let buttonContainer = document.getElementById('button-container');

    // buttonContainer가 존재하지 않는 경우 새로운 요소를 만들어 추가
    if (!buttonContainer) {
        buttonContainer = document.createElement('div');
        buttonContainer.id = 'button-container';
        document.body.appendChild(buttonContainer);
    }

    // 이미 예약 정보 확인 버튼이 있는 경우 추가하지 않음
    if (!document.getElementById('reservation-button')) {
        const reservationButton = document.createElement('button');
        reservationButton.id = 'reservation-button';
        reservationButton.textContent = '예약 정보 확인';
        reservationButton.addEventListener('click', () => {
            checkReservationInfo();
        });
        buttonContainer.appendChild(reservationButton);

        // 예약 정보 확인 버튼을 테이블 아래로 이동
        const timeTableContainer = document.getElementById('timeTableContainer');
        timeTableContainer.appendChild(buttonContainer);

        // 버튼 가로폭 조절
        reservationButton.style.width = '100px'; // 예시로 200px로 설정
    }
}

// 예약 정보 확인 버튼을 제거하는 함수
function removeReservationButton() {
    const buttonContainer = document.getElementById('button-container');
    const reservationButton = document.getElementById('reservation-button');
    if (buttonContainer && reservationButton) {
        buttonContainer.removeChild(reservationButton);
    }
}

// Set 객체를 전역으로 선언하여 중복된 시간대를 제거
const selectedTimeSet = new Set();

// 예약 정보 확인 버튼을 클릭했을 때의 동작을 처리하는 함수
function checkReservationInfo() {
    // 중복된 항목이 없는지 확인하고 Set에 추가
    selectedTimeSet.clear(); // 기존에 선택된 시간대 초기화

    selectedTimeSlots.forEach(slot => {
        const timeSlotString = `${slot.start}:00-${slot.end + 1}:00`;
        selectedTimeSet.add(timeSlotString);
    });

    // Set을 배열로 변환하여 선택한 시간대 정보를 얻음
    const selectedTimeInfo = Array.from(selectedTimeSet).join(',');

    // 오늘의 날짜 정보
    const now = new Date();
    const currentDate = now.toLocaleDateString();

    // seat.js에서 선택한 좌석 정보를 가져와서 화면에 나타냄
    const selectedSeatsString = localStorage.getItem('selectedSeatsString');
    const selectedSeatsElement = document.getElementById('selectedSeatsElement');
    if (selectedSeatsElement) {
        selectedSeatsElement.textContent = `Selected Seats: ${selectedSeatsString}`;
    }

    // GET 요청에 선택한 시간대, 날짜, 좌석 정보를 추가하여 reservate_details.php 페이지로 이동
    window.location.href = `reservate_details.php?selectedTime=${selectedTimeInfo}&currentDate=${currentDate}&selectedSeats=${selectedSeatsString}`;
}

// 드래그 시작 및 종료 이벤트 처리
document.addEventListener('mousedown', () => {
    isDragging = true;
});

document.addEventListener('mouseup', () => {
    isDragging = false;
});

// 초기 현재 날짜 표시와 예약 정보 표시
const currentDate = new Date();
const currentYear = currentDate.getFullYear();
const currentMonth = currentDate.getMonth();
const lastDay = new Date(currentYear, currentMonth + 1, 0).getDate();
displayCurrentDateReservation();
updateMonthYear(currentYear, currentMonth);

// 함수 추가: 헤더의 년월 정보 업데이트
function updateMonthYear(year, month) {
    const monthYearElement = document.getElementById('current-month-year');
    monthYearElement.textContent = `${year}년 ${month + 1}월`;
}

// 예약 시간 (3분)
let reservationTime = 3 * 60; // 초 단위로 변환

// countdown-timer 엘리먼트 가져오기
const countdownTimer = document.getElementById('countdown-timer');

// 1초마다 실행되는 함수
const updateTimer = () => {
    if (reservationTime > 0) {
        const minutes = Math.floor(reservationTime / 60);
        const seconds = reservationTime % 60;
        countdownTimer.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        reservationTime -= 1;
    } else {
        countdownTimer.textContent = '예약 시간 종료'; // 시간 종료 메시지
        // 타이머가 종료되면 reservation.php 페이지로 이동
        window.location.href = 'reservation.php';
    }
};

// 초기 타이머 시작
updateTimer();

// 1초마다 updateTimer 함수 실행
setInterval(updateTimer, 1000);