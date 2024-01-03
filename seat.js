const movieSelect = document.getElementById('movie');
const container = document.querySelector('.container');
const seats = document.querySelectorAll('.row .seat:not(.occupied)');
const tables = document.querySelectorAll('.row .table:not(.occupied)'); // 테이블 선택
const count = document.getElementById('count');
const tableCount = document.getElementById('tableCount'); // 추가된 테이블 개수 표시
const totalCount = document.querySelectorAll('.row .seat').length;
const reservedSeats = calculateReservedSeats(); // ReservedSeats 계산 함수
const selectedSeatsNumbersElement = document.getElementById('selectedSeatsNumbers');

let ticketPrice = +movieSelect.value;
let selectedSetCount = 0; // 선택된 set 개수를 추적

// totalCount를 HTML에 표시
const totalCountElement = document.getElementById('totalCount'); // HTML에서 해당 표시할 요소의 id를 지정해야 합니다.
totalCountElement.textContent = totalCount; // totalCount 값을 할당하여 HTML에 표시

populateUI();

function populateUI() {
  const selectedSeats = JSON.parse(localStorage.getItem('selectedSeats'));

  if (selectedSeats !== null && selectedSeats.length > 0) {
    selectedSeats.forEach((seatIndex) => {
      if (seatIndex < seats.length) {
        seats[seatIndex].classList.add('selected');
      } else if (seatIndex < seats.length + tables.length) {
        const tableIndex = seatIndex - seats.length;
        tables[tableIndex].classList.add('selected');
      }
    });
  }

  const selectedMovieIndex = localStorage.getItem('selectedMovieIndex');

  if (selectedMovieIndex !== null) {
    movieSelect.selectedIndex = selectedMovieIndex;
  }
}

function setMovieData(movieIndex, moviePrice) {
  localStorage.setItem('selectedMovieIndex', movieIndex);
  localStorage.setItem('selectedMoviePrice', moviePrice);
}

function updateSelectedCount() {
  const selectedSeats = document.querySelectorAll('.row .seat.selected');
  const selectedTables = document.querySelectorAll('.row .table.selected');
  const selectedSeatCount = selectedSeats.length;
  const selectedTableCount = selectedTables.length;

  // 여기서 selectedSetCount 업데이트
  selectedSetCount = document.querySelectorAll('.set .seat.selected').length > 0 ? 1 : 0;

  count.textContent = selectedSeatCount;
  tableCount.textContent = selectedTableCount;

  // 선택된 좌석 번호를 표시하는 코드 추가
  const selectedSeatsNumbers = Array.from(selectedSeats).map(seat => seat.getAttribute('data-seat'));
  selectedSeatsNumbersElement.textContent = selectedSeatsNumbers.join(', ');

  // 수정된 부분
  if (selectedSeatCount + selectedTableCount >= 7 || selectedTableCount >= 3) {
    alert('1인당 최대 예약 가능 좌석 수는 2개까지 입니다.');
    // 선택한 좌석 중 가장 나중에 선택한 좌석 또는 테이블을 자동으로 취소합니다.
    const lastSelected = selectedSeatCount + selectedTableCount >= 7 ? selectedSeats[selectedSeats.length - 1] : selectedTables[selectedTables.length - 1];
    
    // 선택된 좌석 및 테이블 취소 코드 추가
    selectedSeats.forEach((seat) => {
        seat.classList.remove('selected');
    });

    selectedTables.forEach((table) => {
        table.classList.remove('selected');
    });

    // 선택된 set 개수 감소
    selectedSetCount--;

    // 업데이트 함수 호출
    updateSelectedCount();
  }
}

movieSelect.addEventListener('change', (event) => {
  ticketPrice = +event.target.value;

  setMovieData(event.target.selectedIndex, event.target.value);
  updateSelectedCount();
});

container.addEventListener('click', (event) => {
  if (event.target.classList.contains('seat') && !event.target.classList.contains('occupied')) {
    // 좌석을 클릭한 경우
    const selectedSeats = document.querySelectorAll('.row .seat.selected');
    const selectedTables = document.querySelectorAll('.row .table.selected');
    const selectedSeatNumbers = Array.from(selectedSeats).map(seat => seat.getAttribute('data-seat'));

    if (selectedSetCount <= 2) {
      if (selectedSeats.length < 5 || event.target.classList.contains('selected')) {
        // 이미 선택된 좌석을 다시 클릭하면 취소
        event.target.classList.toggle('selected');
        updateSelectedCount();
      } else {
        alert('5개 이상의 좌석을 선택할 수 없습니다.');
      }
    } else {
      alert('3개 이상의 set를 선택할 수 없습니다.');
    }
  } else if (event.target.classList.contains('table')) {
    // 테이블을 클릭한 경우
    const set = event.target.closest('.set');

    if (set) {
      const seatsInSet = set.querySelectorAll('.seat:not(.occupied)');
      const tablesInSet = set.querySelectorAll('.table:not(.occupied)');
      const selectedSeats = document.querySelectorAll('.row .seat.selected');
      const selectedTables = document.querySelectorAll('.row .table.selected');
      let seatNumbers = [];
      let tableNumbers = [];

      if (selectedTables.length <= 2) {
        if (selectedSetCount <= 2) {
          // 선택된 set가 2개 이하인 경우
          seatsInSet.forEach((seat) => {
            seat.classList.toggle('selected');
            // 추가한 부분
            if (seat.classList.contains('selected')) {
              seatNumbers.push(seat.getAttribute('data-seat'));
            }
          });

          tablesInSet.forEach((table) => {
            table.classList.toggle('selected');
          });

          selectedSetCount++;
          updateSelectedCount();
        } else {
            alert('3개 이상의 set를 선택할 수 없습니다.');
            // 선택한 set 전체를 취소합니다.
            seatsInSet.forEach((seat) => {
              if (seat.classList.remove('selected')) {
                seat.classList.contains('selected');
              }
            });
          
            tablesInSet.forEach((table) => {
              if (table.classList.remove('selected')) {
                table.classList.contains('selected');
              }
            });
          
            updateSelectedCount();
          }
        } else {
          alert('1인당 최대 예약 가능 테이블 수는 2개까지 입니다.');
          
          // 선택된 좌석 및 테이블 취소 코드 추가
          selectedSeats.forEach((seat) => {
            seat.classList.remove('selected');
          });
          
          selectedTables.forEach((table) => {
            table.classList.remove('selected');
          });
          
          // 선택된 set 개수 감소
          selectedSetCount--;
          
          // 업데이트 함수 호출
          updateSelectedCount();
        }
      }
    }
});

// Grazie_reservation.php에 저장된 좌석 정보
const server_seat_coordinates = [
  { "data-set": 3, "data-x1": 1265, "data-y1": 411, "data-x2": 1471, "data-y2": 606, "label": "on_table" },
  { "data-set": 2, "data-x1": 304, "data-y1": 500, "data-x2": 792, "data-y2": 1075, "label": "on_table" },
  { "data-set": 4, "data-x1": 1305, "data-y1": 426, "data-x2": 1530, "data-y2": 627, "label": "on_table" }
];

// Grazie_reservation.php에 저장된 좌석 데이터를 기반으로 좌석을 확인하고 occupied로 설정
function updateSeats(server_seat_coordinates) {
  seats.forEach((seat) => {
    const data_set = parseInt(seat.getAttribute('data-set'));
    const data_x1 = parseInt(seat.getAttribute('data-x1'));
    const data_y1 = parseInt(seat.getAttribute('data-y1'));
    const data_x2 = parseInt(seat.getAttribute('data-x2'));
    const data_y2 = parseInt(seat.getAttribute('data-y2'));

    server_seat_coordinates.forEach((server_seat) => {
      const server_data_set = server_seat["data-set"];
      const server_data_x1 = server_seat["data-x1"];
      const server_data_y1 = server_seat["data-y1"];
      const server_data_x2 = server_seat["data-x2"];
      const server_data_y2 = server_seat["data-y2"];
      const label = server_seat["label"];

      if (
        data_set === server_data_set &&
        data_x1 === server_data_x1 &&
        data_y1 === server_data_y1 &&
        data_x2 === server_data_x2 &&
        data_y2 === server_data_y2 &&
        label === "on_table"
      ) {
        seat.classList.add('occupied');
      }
    });
  });
}

// 받은 좌석 정보를 기반으로 좌석 상태를 업데이트하는 함수
function updateSeatStatus() {
  server_seat_coordinates.forEach(seat => {
    const set = document.querySelector(`div[data-set="${seat['data-set']}"]`);
    if (seat['label'] === 'on_table') {
      set.classList.add('occupied');
    }
  });
}

// 예약된 좌석 수 계산 함수 (occupied 클래스를 가진 요소 수)
function calculateReservedSeats() {
  const occupiedSeatElements = document.querySelectorAll('.seat.occupied');
  const reservedSeats = occupiedSeatElements.length;
  return reservedSeats;
}

// 페이지 로드 시 좌석 상태를 업데이트합니다.
document.addEventListener('DOMContentLoaded', function() {
  updateSeatStatus();
});

// "Select Time" 버튼 클릭 이벤트 핸들러 추가
const selectTimeButton = document.querySelector('.rm-button-open');
selectTimeButton.addEventListener('click', (event) => {
  event.preventDefault(); // 기본 동작인 링크 이동을 막음

  // 선택된 좌석 수와 테이블 수 가져오기
  const selectedSeats = document.querySelectorAll('.row .seat.selected');
  const selectedTables = document.querySelectorAll('.row .table.selected');
  const selectedSeatCount = selectedSeats.length;
  const selectedTableCount = selectedTables.length;
  const selectedSeatsNumbersArray = Array.from(selectedSeats).map(seat => seat.getAttribute('data-seat'));
  const selectedSeatsString = selectedSeatsNumbersArray.join(',');
          
  // 만약 좌석 또는 테이블을 하나도 선택하지 않은 경우
  if (selectedSeatCount === 0 && selectedTableCount === 0) {
    alert('좌석 또는 테이블을 선택해야 날짜 선택이 가능합니다.');
  } else {
      // 좌석 또는 테이블이 선택되었을 경우, "realtime.php"로 이동
      window.location.href = `realtime.php?selectedSeats=${selectedSeatsString}`;
    }
});