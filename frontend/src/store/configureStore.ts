import { createStore } from 'redux';

import appReducer from "./reducers/index";
import initialState from './initialState';

export const store = createStore(appReducer, initialState);
