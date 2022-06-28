import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyBESuOeNOevWXRZbIRajR-vWwNMNRjPBiY",
    authDomain: "faster-69b8c.firebaseapp.com",
    projectId: "faster-69b8c",
    storageBucket: "faster-69b8c.appspot.com",
    messagingSenderId: "478886809786",
    appId: "1:478886809786:web:f36094d74eca2c8bdab283",
    measurementId: "G-CP9K3KTBSW"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
