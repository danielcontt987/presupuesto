// composables/useTheme.js
import { useTheme } from 'vuetify'

export function useCustomTheme() {
  const theme = useTheme()

  // Lee desde localStorage
  const current = localStorage.getItem('theme') || 'customLightTheme'
  theme.global.name.value = current

  function toggleTheme() {
    theme.global.name.value = theme.global.name.value === 'customLightTheme'
      ? 'customDarkTheme'
      : 'customLightTheme'

    localStorage.setItem('theme', theme.global.name.value)
  }

  return { toggleTheme, themeName: theme.global.name }
}
