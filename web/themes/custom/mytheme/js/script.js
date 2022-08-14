let darkMode;
function darkModeSwitch () {
  darkMode = document.getElementsByClassName("dark-off");

  if(darkMode.length){
    Object.values(darkMode).forEach(elem => {
      elem.classList.remove("dark-off");
      elem.classList.add("dark");
    })
  }else{
    darkMode = document.getElementsByClassName("dark");
    
    Object.values(darkMode).forEach(elem => {
      elem.classList.remove("dark");
      elem.classList.add("dark-off");
    })
  }
}