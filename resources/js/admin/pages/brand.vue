<template>
    <div>
        <div class="content">
            <div class="container-fluid">

                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Products
                        <Button v-if="isWritePermitted" @click="addModal=true">
                            <Icon type="md-add"/>
                            Add new brand
                        </Button>
                    </p>

                    <div class="_overflow _table_div">
                        <table class="table table-bordered text-center">
                            <!-- TABLE TITLE -->
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Brand logo</th>
                                <th>Brand name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <!-- TABLE TITLE -->


                            <!-- ITEMS -->
                            <tbody>
                            <tr v-for="(brand,i) in brandLists" :key="i" v-if="brandLists.length">
                                <td>{{brand.id}}</td>
                                <td class="table_image"><img :src="`${brand.brandLogo}`"/></td>
                                <td class="text-bold">{{brand.brandName}}</td>
                                <td>{{brand.description}}</td>

                                <td>
                                    <Button v-if="isUpdatePermitted" type="info" size="small" @click="showEditModal(brand,i)">Edit</Button>
                                    <Button v-if="isDeletePermitted" type="error" size="small" @click="showDeletingModal(brand,i)"
                                            :loading="brand.isDeleting">Delete
                                    </Button>
                                </td>
                            </tr>
                            </tbody>
                            <!-- ITEMS -->


                        </table>
                    </div>

                    <!-- tag Modal -->
                    <Modal
                        v-model="addModal"
                        title="Add category"
                        :mask-closable="false"
                        :closable="false"
                    >

                        <div class="space">
                            <Input v-model="data.brandName" size="large" placeholder="Product name"/>
                        </div>

                        <div class="space">
                            <textarea v-model="data.description" style="width: 500px;height: 150px" size="large" placeholder="Description"/>
                        </div>


                        <div class="space">
                            <Upload
                                ref="uploads"
                                multiple
                                type="drag"
                                :headers="{'x-csrf-token':token,'X-Requested-With':'XMLHttpRequest'}"
                                :on-success="handleSuccess"
                                :on-error="handleError"
                                :max-size="2048"
                                :on-format-error="handleFormatError"
                                :format="['jpg','jpeg','png']"
                                :on-exceeded-size="handleMaxSize"

                                action="/app/upload">
                                <div style="padding: 20px 0">
                                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                    <p>Click or drag files here to upload</p>
                                </div>
                            </Upload>
                            <div class="demo-upload-list" v-if="data.brandLogo">
                                <img :src="`${data.brandLogo}`"/>
                                <div class="demo-upload-list-cover">
                                    <Icon type="ios-trash-outline" @click="deleteImage"></Icon>
                                </div>

                            </div>
                        </div>
                        <div slot="footer">
                            <Button type="primary" @click="add" :disabled="isAdding" :loading="isAdding">
                                {{isAdding?'Adding..':'Add brand'}}
                            </Button>
                            <Button type="default" @click="addModal=false">Close</Button>
                        </div>
                    </Modal>

                    <!--Edit modal -->
                    <Modal
                        v-model="editModal"
                        title="Edit category"
                        :mask-closable="false"
                        :closable="false"
                    >

                        <div class="space">
                            <Input v-model="editData.productName" size="large" placeholder="Product name"/>
                        </div>

                        <div class="space">
                            <!--                           // <Input v-model="data.productName" size="large" placeholder="Product name"/>-->
                            <textarea v-model="editData.description" style="width:100%"
                                      placeholder="Product description"></textarea>

                        </div>

                        <div class="space">
                            <Input v-model="editData.price" size="large" placeholder="Price"/>
                        </div>

                        <div class="space">
                            <Input v-model="editData.quantity" size="large" placeholder="Quantity in stock"/>
                        </div>

                        <div class="space">
                            <Upload v-show="isproductImageNew"
                                    ref="editDataUploads"
                                    multiple
                                    type="drag"
                                    :headers="{'x-csrf-token':token,'X-Requested-With':'XMLHttpRequest'}"
                                    :on-success="handleSuccess"
                                    :on-error="handleError"
                                    :max-size="2048"
                                    :on-format-error="handleFormatError"
                                    :format="['jpg','jpeg','png']"
                                    :on-exceeded-size="handleMaxSize"

                                    action="/app/upload">
                                <div style="padding: 20px 0">
                                    <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                    <p>Click or drag files here to upload</p>
                                </div>
                            </Upload>
                            <div class="demo-upload-list" v-if="editData.productImage">
                                <img :src="`${editData.productImage}`"/>
                                <div class="demo-upload-list-cover">
                                    <Icon type="ios-trash-outline" @click="deleteImage(false)"></Icon>
                                </div>

                            </div>

                        </div>
                        <div slot="footer">
                            <Button type="primary" @click="edit" :disabled="isAdding" :loading="isAdding">
                                {{isAdding?'Editing..':'Edit brand'}}
                            </Button>
                            <Button type="default" @click="closeEditModal">Close</Button>
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
                    brandLogo: '',
                    brandName: '',
                    description:''

                },
                addModal: false,
                editModal: false,
                isAdding: false,
                brandLists: [],
                editData: {
                    brandLogo: '',
                    brandName: '',
                    description:''
                },
                index: -1,
                showDeleteModal: false,
                isDeleting: false,
                deleteItem: {},
                deletingIndex: -1,
                token: '',
                isproductImageNew: false,
                isEditingItem: false,
            }
        },
        methods: {
            async add() {
                if (this.data.brandLogo.trim() == '') {
                    return this.e('Brand logo is required');
                }
                if (this.data.brandName.trim() == '') {
                    return this.e('Brand name is required');
                }

                // if (this.data.description.trim() == '') {
                //     return this.e('Product price is required');
                // }


                this.data.brandLogo = `${this.data.brandLogo}`
                const res = await this.callApi('post', 'app/create_brand', this.data);
                if (res.status === 201) {
                    this.brandLists.unshift(res.data);
                    this.s('Brand has been added successfully!');
                    this.addModal = false;
                    this.data.brandLogo = ''
                    this.data.brandName = ''
                    this.data.description = ''

                } else {
                    if (res.status == 422) {
                        if (res.data.errors.brandName) {
                            this.e(res.data.errors.productName[0]);
                        }
                        if (res.data.errors.brandLogo) {
                            this.e(res.data.errors.productImage[0]);
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

                const res = await this.callApi('post', 'app/edit_brand', this.editData);
                if (res.status === 200) {

                    this.brandLists[this.index].brandName = this.editData.brandName;
                    this.s('Brand has been updated successfully!');
                    this.editModal = false;
                } else {
                    if (res.status == 422) {
                        if (res.data.errors.brandName) {
                            this.e(res.data.errors.categoryName[0]);
                        }
                        if (res.data.errors.brandLogo) {
                            this.e(res.data.errors.productImage[0]);
                        }
                    } else {
                        this.swr();
                    }

                }
            },
            showEditModal(brand, index) {
                let obj = {
                  id:brand.id,
                  brandName:brand.brandName,
                  brandLogo:brand.brandLogo
                }

                this.editData = obj
                this.editModal = true
                this.index = index;
                this.isEditingItem = true
            },
            showDeletingModal(category, i) {

                const deleteModalObj = {
                    showDeleteModal: true,
                    deleteUrl: 'app/delete_brand',
                    data: category,
                    deletingIndex: i,
                    isDeleted: false

                }
                //console.log(deleteModalObj);

                this.$store.commit('setDeletingModalObj', deleteModalObj);
                // this.deleteItem = tag;
                // this.deletingIndex = i
                // this.showDeleteModal = true
            },
            handleSuccess(res, file) {
                res = `/uploads/${res}`;
                if (this.isEditingItem) {
                   // console.log('inside');
                    return this.editData.brandLogo = res
                }

                this.data.brandLogo = res

            },
            handleFormatError(file) {
                this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
                });
            },
            handleMaxSize(file) {
                this.$Notice.warning({
                    title: 'Exceeding file size limit',
                    desc: 'File  ' + file.name + ' is too large, no more than 2M.'
                });
            },
            handleError(res, file) {
                // console.log('res',res);
                // console.log('file',file);
                this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: `${file.errors.file.length ? file.errors.file[0] : 'Something went wrong'}`
                });
            }, handleBeforeUpload() {
                const check = this.uploadList.length < 5;
                if (!check) {
                    this.$Notice.warning({
                        title: 'Up to five pictures can be uploaded.'
                    });
                }
                return check;
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
             const res = await this.callApi('get', 'app/get_brand');

            if (res.status == 200) {
                this.brandLists = res.data
            } else {
                this.swr();
            }

        },
        components: {
            deleteModal
        },
        watch: {
            getDeleteModalObj(obj) {
                console.log(obj);
                if (obj.isDeleted) {
                    this.productLists.splice(obj.deletingIndex, 1);
                }
            }
        },


    }
</script>
