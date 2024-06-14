let resizer = document.querySelector('.frame_resizer');
let frameWrapper = document.querySelector('#frame_wrapper')
console.log("Hello")
let prevY = 0;
resizer.addEventListener('mousedown', (e) => {
    console.log('Mouse down')
    prevY = e.clientY
})
resizer.addEventListener('mousemove', (e) => {
    let delY = e.clientY - prevY
    let height = frameWrapper.clientHeight;
    frameWrapper.styles.height = `${height + delY}px`
    prevY = e.clientY
})