import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        counter: 1000,
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
            totalPrice:0
        },
        user: false,
        userPermission: null,
        cartProduct: null,
        price:0
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
            // if (this.cartProduct) {
            //     state.cartModalObj.data = state.cartProduct;
            // }
            if(state.cartProduct){
                state.cartModalObj.data=state.cartProduct;
            }
            if(state.cartModalObj.totalPrice!=0)
            {
                state.cartModalObj.totalPrice=state.price;
            }

            return state.cartModalObj;
            // else
            // {
            //     return this.setCartModalObj();
            // }
        },
        getCartModalProduct(state) {
            return state.cartProduct;
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
            // if(data==null){
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
            console.log(state.cartProduct)
        },
        setTotalPrice(state,data){
            state.price=data;
        }


    },
    actions: {
        changeCounterAction({commit}, data) {
            commit('changeTheCounter', data);
        }
    }
})

