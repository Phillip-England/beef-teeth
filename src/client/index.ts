/// <reference lib="dom" />
/// <reference lib="dom.iterable" />


import { classBanger } from "./utility";

const router: Map<string, () => void> = new Map();

//=====================================================================
// EVENTS
//=====================================================================

const eToggleLanguageButton = () => {
	let englishButton = document.getElementById('english-button') as HTMLElement
	let spanishButton = document.getElementById('spanish-button') as HTMLElement
	let hiddenLanguageInput = document.getElementById('language-input') as HTMLInputElement
	hiddenLanguageInput.value = 'english'
	englishButton.addEventListener('click', () => {
		hiddenLanguageInput.value = 'english' 
		classBanger(spanishButton, ['bg-white', 'text-black'], ['bg-black', 'text-white'])
		classBanger(englishButton, ['bg-black', 'text-white'], ['bg-white', 'text-black'])
	})
	spanishButton.addEventListener('click', () => {
		hiddenLanguageInput.value = 'spanish';
		classBanger(englishButton, ['bg-white', 'text-black'], ['bg-black', 'text-white'])
		classBanger(spanishButton, ['bg-black', 'text-white'], ['bg-white', 'text-black'])
	})
}

//=====================================================================
// ROUTES
//=====================================================================

router.set("/root/user", () => {
	console.log("/root/user")
	eToggleLanguageButton()
})

router.set("/root", () => {
	console.log("/root")
	eToggleLanguageButton()
})

const eventHook = router.get(window.location.pathname)
if (eventHook) {
	eventHook();
}
