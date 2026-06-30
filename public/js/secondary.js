let greenA = document.querySelector('.leftGreen');
function GreenHeader(){
    // this.setAttribute("style","background-color: rgb(150, 185, 125); font-weight: bold; color: rgb(255, 255, 255)")
    this.classList.add('leftGreens'); // 给a元素添加新样式类
}
greenA.addEventListener('click',GreenHeader)