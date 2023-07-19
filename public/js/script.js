// создаем локальные переменные для карты и маркера
// каждый модуль имеет собственное пространство имен
let map = null
let marker = null

// функция принимает позицию - массив с широтой и долготой
// и сообщение, отображаемое над маркером (tooltip)
function getMap(position, tooltip) {
    // если карта не была инициализирована
    if (map === null) {
        // второй аргумент, принимаемый методом setView - это масштаб (zoom)
        map = L.map('map').setView(position, 15)
    } else return

    // что-то типа рекламы
    // без этого карта работать не будет
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution:
            '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map)

    // добавляем маркер с сообщением
    L.marker(position).addTo(map).bindPopup(tooltip).openPopup()
}

function success({ coords }) {
    const { latitude, longitude } = coords
    const currentPosition = [latitude, longitude]
    // вызываем функцию, передавая ей текущую позицию и сообщение
    getMap(currentPosition, 'You are here')
}

function error({ message }) {
    console.log(message)
}

$(document).ready(function(){
    // находим кнопку и добавляем к ней обработчик
    document.getElementById('my_position').onclick = () => {
        navigator.geolocation.getCurrentPosition(success, error, {
            enableHighAccuracy: true
        })
    }
})