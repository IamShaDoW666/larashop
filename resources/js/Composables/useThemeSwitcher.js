import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
export function useThemeSwitcher() {
	const currentTheme = ref(localStorage.getItem('theme'));

	function toggleTheme() {
		if (currentTheme.value == 'dark') {
			setLightTheme();
            location.reload()
		} else {
			setDarkTheme();
            location.reload()
		}
	}

	// Light Theme Function
	function setLightTheme() {
		currentTheme.value = 'light';

		localStorage.setItem('theme', 'light');
	}

	// Dark Theme Function
	function setDarkTheme() {
		currentTheme.value = 'dark';

		localStorage.setItem('theme', 'dark');
	}

	return {
		toggleTheme,
        currentTheme
	};
}
