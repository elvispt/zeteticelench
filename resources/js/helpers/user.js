import axios from "axios";

const userDataStorageKey = "ZE_UserInfo";

export function getLocalUser() {
  let userData;
  try {
    userData = JSON.parse(window.localStorage.getItem(userDataStorageKey));
  } catch (e) {
    userData = null;
  }

  return userData;
}

export function setLocalUser(userData) {
  const userStr = JSON.stringify(userData);
  window.localStorage.setItem(userDataStorageKey, userStr);
}

export function clearLocalUser() {
  window.localStorage.removeItem(userDataStorageKey);
}

export async function isUserAuthenticated() {
  const userIsAuthenticatedStatusCode = 200;
  let success;
  try {
    const response = await axios.get('/api/users/currentUser');
    success = response.status === userIsAuthenticatedStatusCode;
  } catch (err) {
    success = false;
  }

  return success;
}
