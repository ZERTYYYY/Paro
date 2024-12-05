let togg1 = document.getElementById("togg1");
let togg2 = document.getElementById("togg2");
let togg3 = document.getElementById("togg3");
let togg4 = document.getElementById("togg4");
let togg5 = document.getElementById("togg5");
let togg6 = document.getElementById("togg6");
let togg7 = document.getElementById("togg7");
let togg8 = document.getElementById("togg8");
let togg9 = document.getElementById("togg9");
let d1 = document.getElementById("d1");
let d2 = document.getElementById("d2");
let d3 = document.getElementById("d3");
d1.style.display = "block";
d2.style.display = "none";
d3.style.display = "none";
togg1.addEventListener("click", () => {
    d1.style.display = "block";
    d2.style.display = "none";
    d3.style.display = "none";
  }
)
togg2.addEventListener("click", () => {
  d1.style.display = "none";
  d2.style.display = "flex";
  d3.style.display = "none";
}
)
togg3.addEventListener("click", () => {
  d1.style.display = "none";
  d2.style.display = "none";
  d3.style.display = "flex";
}
)


togg4.addEventListener("click", () => {
  d1.style.display = "block";
  d2.style.display = "none";
  d3.style.display = "none";
}
)
togg5.addEventListener("click", () => {
  d1.style.display = "none";
  d2.style.display = "flex";
  d3.style.display= "none";
}
)
togg6.addEventListener("click", () => {
  d1.style.display = "none";
  d2.style.display = "none";
  d3.style.display= "flex";
}
)

togg7.addEventListener("click", () => {
  d1.style.display = "block";
  d2.style.display = "none";
  d3.style.display = "none";
}
)
togg8.addEventListener("click", () => {
  d1.style.display = "none";
  d2.style.display = "flex";
  d3.style.display= "none";
}
)
togg9.addEventListener("click", () => {
  d1.style.display = "none";
  d2.style.display = "none";
  d3.style.display= "flex";
  }
  )








