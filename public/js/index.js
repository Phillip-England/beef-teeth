// src/client/utility.ts
var classBanger = (element, add, remove) => {
  if (add && add.length > 0) {
    element.classList.add(...add);
  }
  if (remove && remove.length > 0) {
    element.classList.remove(...remove);
  }
};

// src/client/index.ts
var router = new Map;
var eToggleLanguageButton = () => {
  let englishButton = document.getElementById("english-button");
  let spanishButton = document.getElementById("spanish-button");
  let hiddenLanguageInput = document.getElementById("language-input");
  hiddenLanguageInput.value = "english";
  englishButton.addEventListener("click", () => {
    hiddenLanguageInput.value = "english";
    classBanger(spanishButton, ["bg-white", "text-black"], ["bg-black", "text-white"]);
    classBanger(englishButton, ["bg-black", "text-white"], ["bg-white", "text-black"]);
  });
  spanishButton.addEventListener("click", () => {
    hiddenLanguageInput.value = "spanish";
    classBanger(englishButton, ["bg-white", "text-black"], ["bg-black", "text-white"]);
    classBanger(spanishButton, ["bg-black", "text-white"], ["bg-white", "text-black"]);
  });
};
router.set("/root/user", () => {
  console.log("/root/user");
  eToggleLanguageButton();
});
router.set("/root", () => {
  console.log("/root");
  eToggleLanguageButton();
});
var eventHook = router.get(window.location.pathname);
if (eventHook) {
  eventHook();
}
