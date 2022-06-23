import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyCW_wO9dXzW6ptdEipsMiK-Iq4KInZHb3Y",
  authDomain: "jksaworktest.firebaseapp.com",
  databaseURL: "https://jksaworktest-default-rtdb.firebaseio.com",
  projectId: "jksaworktest",
  storageBucket: "jksaworktest.appspot.com",
  messagingSenderId: "584180342335",
  appId: "1:584180342335:web:adf7e10545d31a6747228a",
  measurementId: "G-QK6EV5GXJ1"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
