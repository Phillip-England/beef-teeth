/// <reference lib="dom" />
/// <reference lib="dom.iterable" />

export const classBanger = (element: HTMLElement, add: string[], remove: string[]) => {
	if (add && add.length > 0) {
	  element.classList.add(...add);
	}
	if (remove && remove.length > 0) {
	  element.classList.remove(...remove);
	}
}