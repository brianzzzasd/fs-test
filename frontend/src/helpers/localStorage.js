export function getSavedState(key, defaultVal = {}) {
  if (window.localStorage.getItem(key) !== null) {
    return JSON.parse(window.localStorage.getItem(key))
  }

  return defaultVal
}

export function saveState(key, state) {
  window.localStorage.setItem(key, JSON.stringify(state))
}
