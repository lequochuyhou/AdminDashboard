<template>
    <div>
        <div class="content">
            <div class="container-fluid">

                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Products
                        <Button @click="addModal=true">
                            <Icon type="md-add"/>
                            Create new supplier
                        </Button>
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Supplier name</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <th>Edit</th>
                            </tr>
                            <!-- TABLE TITLE -->


                            <!-- ITEMS -->

                            <tr v-for="(supplier,i) in supplierLists" :key="i" v-if="supplierLists.length">
                                <td>{{supplier.id}}</td>
                                <td class="_table_name">{{supplier.supplierName}}</td>
                                <td>{{supplier.created_at}}</td>
                                <td>{{supplier._updated_at}}</td>
                                <Button type="default" @click="showEditModal(supplier,i)">Edit</Button>
<!--                                <Button type="default" @click="addModal">Close</Button>-->

                            </tr>
                            <!-- ITEMS -->


                        </table>
                    </div>

                    <!-- tag Modal -->
                    <Modal
                        v-model="addModal"
                        title="Add supplier"
                        :mask-closable="false"
                        :closable="false"
                    >

                        <div class="space">
                            <label>Suppliers:</label>
                            <Input v-model="data.supplierName" placeholder="Enter something..." style="width: 300px" />
                        </div>
                        <div slot="footer">
                            <Button type="primary" @click="add" :disabled="isAdding" :loading="isAdding">
                                {{isAdding?'Adding..':'Create supplier'}}
                            </Button>
                            <Button type="default" @click="addModal=false">Close</Button>
                        </div>
                    </Modal>

                    <!--Edit modal -->
                    <Modal
                        v-model="editModal"
                        title="Edit supplier"
                        :mask-closable="false"
                        :closable="false"
                    >

                        <div class="space">
                            <label>Suppliers:</label>
                            <Input v-model="editData.supplierName" placeholder="Enter something..." style="width: 300px" />
                        </div>
                        <div slot="footer">
                            <Button type="primary" @click="add" :disabled="isAdding" :loading="isAdding">
                                {{isAdding?'Adding..':'Create supplier'}}
                            </Button>
                            <Button type="default" @click="editModal=false">Close</Button>
                        </div>
                    </Modal>

                    <delete-modal></delete-modal>
                </div>
                <Page :total="100"/>

            </div>
        </div>
    </div>
</template>

<script>
    import deleteModal from '../components/deleteModal.vue'
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                data: {
                    supplierName: '',

                },
                addModal: false,
                editModal: false,
                isAdding: false,
                productLists: [],
                supplierLists:[],
                editData: {
                    supplierName: '',
                },
                index: -1,
                showDeleteModal: false,
                isDeleting: false,
                deleteItem: {},
                deletingIndex: -1,
                token: '',
                isproductImageNew: false,
                isEditingItem: false,
                brands:[],
                categories:[],
                suppliers:[]
            }
        },
        methods: {
            async add() {
                if (this.data.supplierName.trim() == '') {
                    return this.e('Supplier name is required');
                }


                const res = await this.callApi('post', 'app/create_product', this.data);
                if (res.status === 201) {
                    this.supplierLists.unshift(res.data);
                    this.s('Category has been added successfully!');
                    this.addModal = false;
                    this.data.supplierName = ''
                } else {
                    if (res.status == 422) {
                        if (res.data.errors.supplierName) {
                            this.e(res.data.errors.productName[0]);
                        }
                    } else {
                        this.swr();
                    }

                }
            },
            async edit() {
                if (this.editData.categoryName.trim() == '') {
                    return this.e('Category name is required');
                }
                if (this.editData.productImage.trim() == '') {
                    return this.e('Image name is required');
                }

                const res = await this.callApi('post', 'app/edit_category', this.editData);
                if (res.status === 200) {

                    this.categoryLists[this.index].categoryName = this.editData.categoryName;
                    this.s('Product has been updated successfully!');
                    this.editModal = false;
                } else {
                    if (res.status == 422) {
                        if (res.data.errors.categoryName) {
                            this.e(res.data.errors.categoryName[0]);
                        }
                        if (res.data.errors.productImage) {
                            this.e(res.data.errors.productImage[0]);
                        }
                    } else {
                        this.swr();
                    }

                }
            },
            showEditModal(supplier, index) {
                let obj = {
                    id: supplier.id,
                    supplierName:supplier.supplierName

                }

                this.editData = obj
                this.editModal = true
                this.index = index;
                this.isEditingItem = true
            },
            showDeletingModal(category, i) {

                const deleteModalObj = {
                    showDeleteModal: true,
                    deleteUrl:'app/delete_category',
                    data: category,
                    deletingIndex: i,
                    isDeleted: false

                }
                //console.log(deleteModalObj);

                this.$store.commit('setDeletingModalObj',deleteModalObj);
                // this.deleteItem = tag;
                // this.deletingIndex = i
                // this.showDeleteModal = true
            },
            async deleteImage(isAdd = true) {
                let image;
                if (!isAdd)//for edit image
                {
                    this.isproductImageNew = true
                    image = this.data.editData
                    this.editData.productImage = ''
                    this.$refs.editDataUploads.clearFiles()
                } else {
                    image = this.data.productImage
                    this.data.productImage = ''
                    this.$refs.uploads.clearFiles()
                }

                const res = await this.callApi('post', 'app/delete_image', {imageName: image});
                if (res.status != 200) {
                    this.data.productImage = image;
                    this.swr()
                }
            },
            closeEditModal() {
                this.isEditingItem = false
                this.editModal = false
            }
        },
        async created() {
            this.token = window.Laravel.csrfToken;
            //      const res = await this.callApi('get', 'app/get_product');
            const res=await this.callApi('get', 'app/get_supplier');
            if (res.status == 200) {
                this.supplierLists = res.data
            } else {
                this.swr();
            }

            console.log(this.supplierLists)
        },
        components: {
            deleteModal
        },
        watch: {
            getDeleteModalObj(obj){
                console.log(obj);
                if(obj.isDeleted){
                    this.productLists.splice(obj.deletingIndex,1);
                }
            }
        },


    }
</script>
