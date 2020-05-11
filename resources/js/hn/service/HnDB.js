// Get a RTDB instance
import firebase from 'firebase/app';
import 'firebase/database';

export const HnDB = firebase
  .initializeApp({
    databaseURL: 'hacker-news.firebaseio.com',
  })
  .database()
  .ref('/v0')
;
