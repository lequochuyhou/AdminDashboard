import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        counter: 1000,
        loggedInUserObj:{
          isLoggedIn:false,
          user:null
        },
        deleteModalObj: {
            showDeleteModal: false,
            deleteUrl: '',
            data: null,
            deletingIndex: -1,
            isDeleted: false

        },
        cartModalObj: {
            showCartModal: false,
            data: null,
            deletingIndex: -1,
            isDeleted: false,
            totalPrice: 0
        },
        loginModalObj: {
            showLoginModal: false,
            data: null,
            isLoggedin: false
        },
        registerModalObj: {
            showRegisterModal: false,
            data: null
        },
        chatLogModalObj: {
            showChatLogModal: false,
            data: null
        },
        notificationBellIconObj: {
            data:null,
            counter:0
        },
        notificationData: null,
        user: false,
        userPermission: null,
        cartProduct: null,
        price: 0,
        userData: null,
        notifications: null
    },
    getters: {
        getCounter(state) {

            return state.counter
        },
        getDeleteModalObj(state) {
            return state.deleteModalObj;
        },
        getUserPermission(state) {
            return state.userPermission;
        },
        getCartModalObj(state) {

            if (state.cartProduct) {
                state.cartModalObj.data = state.cartProduct;
            }
            if (state.cartModalObj.totalPrice != 0) {
                state.cartModalObj.totalPrice = state.price;
            }

            return state.cartModalObj;

        },
        getCartModalProduct(state) {
            return state.cartProduct;
        },
        getLoginModalObj(state) {
            if (state.userData) {
                state.loginModalObj.data = state.userData;
            }
            return state.loginModalObj;
        },
        getRegisterModalObj(state) {

            return state.registerModalObj;
        },
        getChatLogModalObj(state) {
            return state.chatLogModalObj;
        },
        getNotificationBellIconObj(state) {
            return state.notificationBellIconObj;
        },
        getNotificationData(state) {
            if (state.notifications) {
                state.notificationData = state.notifications;

            }
            return state.notificationData;
        },
        getLoggedInUserObj(state){
            return state.loggedInUserObj;
        }

    },
    mutations: {
        changeTheCounter(state, data) {
            state.counter += data
        },
        SetDeleteModal(state, data) {
            const deleteModalObj = {
                showDeleteModal: false,
                deleteUrl: '',
                data: null,
                deletingIndex: -1,
                isDeleted: data,
            }
            state.deleteModalObj = deleteModalObj
        },
        setDeletingModalObj(state, data) {

            state.deleteModalObj = data
        },
        setUpdateUser(state, data) {
            state.user = data
        },
        setUserPermission(state, data) {
            state.userPermission = data
        },
        setCartModalObj(state, data) {
            state.cartModalObj = data

            // console.log(state.cartModalObj)
        },
        setCartModal(state, data) {

            const cartModalObj = {
                showCartModal: false,
                data: null,
                deletingIndex: -1,
                isDeleted: data
            }
            state.cartModalObj = cartModalObj


        },
        setDataCartModal(state, data) {
            state.cartProduct = data;
            //console.log(state.cartProduct)
        },
        setTotalPrice(state, data) {
            state.price = data;
        },
        setLoginModalObj(state, data) {
            return state.loginModalObj = data;
        },
        setUserData(state, data) {
            return state.userData = data;
        },
        setRegisterModalObj(state, data) {
            return state.registerModalObj = data;
        },
        setChatLogModalObj(state, data) {
            return state.chatLogModalObj = data
        },
        setNotificationBellIcon(state, data) {
            return state.notificationBellIconObj = data
        },
        setNotificationData(state, data) {
            return state.notificationData = data
        },
        setNotification(state, data) {
            return state.notifications = data;
        },
        setLoggedInUserObj(state, data) {
            return state.loggedInUserObj = data;
        }


    },
    actions: {
        changeCounterAction({commit}, data) {
            commit('changeTheCounter', data);
        }
    }
})

