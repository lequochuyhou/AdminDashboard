<template>
    <div>
        <div class="content">
            <div class="container-fluid">

                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Products
                        <Button @click="addModal=true">
                            <Icon type="md-add"/>
                            Create new product
                        </Button>
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Product image</th>
                                <th>Product name</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Brand</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->


                            <!-- ITEMS -->

                            <tr v-for="(product,i) in productLists" :key="i" v-if="productLists.length">
                                <td>{{product.id}}</td>
                                <td class="table_image"><img :src="`${product.productImage}`"/></td>
                                <td class="_table_name">{{product.productName}}</td>
                                <td>{{product.price}} VND</td>
                                <td>{{product.description}}</td>
                                <td>{{product.quantity}}</td>
                                <td>{{}}</td>

                                <td>{{product.created_at}}</td>
                                <td>
                                    <Button type="info" size="small" @click="showEditModal(product,i)">Edit</Button>
                                    <Button type="error" size="small" @click="showDeletingModal(product,i)"
                                            :loading="product.isDeleting">Delete
                                    </Button>
                                </td>
                            </tr>
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
                            <Input v-model="data.productName" size="large" placeholder="Product name"/>
                        </div>

                        <div class="space">
                            <!--                           // <Input v-model="data.productName" size="large" placeholder="Product name"/>-->
                            <textarea v-model="data.description" style="width:100%" placeholder="Product description"></textarea>

                        </div>

                        <div class="space">
                            <Input v-model="data.price" size="large" placeholder="Price"/>
                        </div>

                        <div class="space">
                            <Input v-model="data.quantity" size="large" placeholder="Quantity in stock"/>
                        </div>


                        <div class="space">
                            <label>Brands:</label>
                            <Select
                                v-model="data.brand_id"
                                placeholder="Select brand"
                                style="width: 200px"
                            >
                                <Option :value="brand.id" v-for="(brand,i) in brands" :key="i" v-if="brands.length">
                                    {{brand.brandName}}
                                </Option>
                                <!--                <Option value="Editor">Editor</Option>-->
                            </Select>
                        </div>

                        <div class="space">
                            <label>Categories:</label>
                            <Select
                                v-model="data.category_id"
                                placeholder="Select category"
                                style="width: 200px"
                            >
                                <Option :value="category.id" v-for="(category,i) in categories" :key="i" v-if="categories.length">
                                    {{category.categoryName}}
                                </Option>
                                <!--                <Option value="Editor">Editor</Option>-->
                            </Select>
                        </div>

                        <div class="space">
                            <label>Suppliers:</label>
                            <Select
                                v-model="data.supplier_id"
                                placeholder="Select supply "
                                style="width: 200px"
                            >
                                <Option :value="supplier.id" v-for="(supplier,i) in suppliers" :key="i" v-if="suppliers.length">
                                    {{supplier.supplierName}}
                                </Option>
                                <!--                <Option value="Editor">Editor</Option>-->
                            </Select>
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
                            <div class="demo-upload-list" v-if="data.productImage">
                                <img :src="`${data.productImage}`"/>
                                <div class="demo-upload-list-cover">
                                    <Icon type="ios-trash-outline" @click="deleteImage"></Icon>
                                </div>

                            </div>
                        </div>
                        <div slot="footer">
                            <Button type="primary" @click="add" :disabled="isAdding" :loading="isAdding">
                                {{isAdding?'Adding..':'Create product'}}
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
                            <textarea v-model="editData.description" style="width:100%" placeholder="Product description"></textarea>

                        </div>

                        <div class="space">
                            <Input v-model="editData.price" size="large" placeholder="Price"/>
                        </div>

                        <div class="space">
                            <Input v-model="editData.quantity" size="large" placeholder="Quantity in stock"/>
                        </div>


                        <div class="space">
                            <label>Brands:</label>
                            <Select
                                v-model="editData.brand_id"
                                placeholder="Select brand"
                                style="width: 200px"
                            >
                                <Option :value="brand.id" v-for="(brand,i) in brands" :key="i" v-if="brands.length">
                                    {{brand.brandName}}
                                </Option>
                                <!--                <Option value="Editor">Editor</Option>-->
                            </Select>
                        </div>

                        <div class="space">
                            <label>Categories:</label>
                            <Select
                                v-model="editData.category_id"
                                placeholder="Select category"
                                style="width: 200px"
                            >
                                <Option :value="category.id" v-for="(category,i) in categories" :key="i" v-if="categories.length">
                                    {{category.categoryName}}
                                </Option>
                                <!--                <Option value="Editor">Editor</Option>-->
                            </Select>
                        </div>

                        <div class="space">
                            <label>Suppliers:</label>
                            <Select
                                v-model="editData.supplier_id"
                                placeholder="Select supply "
                                style="width: 200px"
                            >
                                <Option :value="supplier.id" v-for="(supplier,i) in suppliers" :key="i" v-if="suppliers.length">
                                    {{supplier.supplierName}}
                                </Option>
                                <!--                <Option value="Editor">Editor</Option>-->
                            </Select>
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
                                {{isAdding?'Editing..':'Edit category'}}
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
                    productImage: '',
                    productName: '',
                    price:'',
                    quantity:'',
                    description:'',
                    brand_id:null,
                    category_id:null,
                    supplier_id:null

                },
                addModal: false,
                editModal: false,
                isAdding: false,
                productLists: [],
                editData: {
                    productImage: '',
                    productName: '',
                    price:'',
                    quantity:'',
                    description:'',
                    brand_id:null,
                    category_id:null,
                    supplier_id:null
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
                if (this.data.productName.trim() == '') {
                    return this.e('Product name is required');
                }
                if (this.data.productImage.trim() == '') {
                    return this.e('Product image is required');
                }

                if (this.data.price.trim() == '') {
                    return this.e('Product price is required');
                }

                if (this.data.quantity.trim() == '') {
                    return this.e('Product quantity is required');
                }

                if (this.data.description.trim() == '') {
                    return this.e('Product quantity is required');
                }

                // if (!this.data.brand_id) {
                //     return this.e('Image name is required');
                // }
                //
                // if (!this.data.category_id) {
                //     return this.e('Image name is required');
                // }
                //
                // if (!this.data.supplier_id) {
                //     return this.e('Image name is required');
                // }

                this.data.productImage=`${this.data.productImage}`
                const res = await this.callApi('post', 'app/create_product', this.data);
                if (res.status === 201) {
                    this.productLists.unshift(res.data);
                    this.s('Category has been added successfully!');
                    this.addModal = false;
                    this.data.productImage = ''
                    this.data.description = ''
                    this.data.productName = ''
                    this.data.price=null
                    this.data.quantity=null

                } else {
                    if (res.status == 422) {
                        if (res.data.errors.productName) {
                            this.e(res.data.errors.productName[0]);
                        }
                        if (res.data.errors.productImage) {
                            this.e(res.data.errors.productImage[0]);
                        }

                        if (res.data.errors.price) {
                            this.e(res.data.errors.price[0]);
                        }

                        if (res.data.errors.quantity) {
                            this.e(res.data.errors.quantity[0]);
                        }

                        // if (res.data.errors.productImage) {
                        //     this.e(res.data.errors.productImage[0]);
                        // }
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
            showEditModal(product, index) {
                let obj = {
                    id: product.id,
                    productName: product.productName,
                    productImage: product.productImage,
                    price: product.price,
                    quantity: product.quantity,
                    description: product.description,
                    brand_id: product.brand_id,
                    category_id: product.category_id,
                    supplier_id: product.supplier_id,
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
            handleSuccess(res, file) {
                res = `/uploads/${res}`;
                if (this.isEditingItem) {
                    console.log('inside');
                    return this.editData.productImage = res
                }

                this.data.productImage = res

                // console.log(this.data.productImage)
                // file.url = 'https://o5wwk8baw.qnssl.com/7eb99afb9d5f317c912f08b5212fd69a/avatar';
                // file.name = '7eb99afb9d5f317c912f08b5212fd69a';
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
            //      const res = await this.callApi('get', 'app/get_product');
            const [res,resBrand,resCat,resSuppier]=await Promise.all([
                this.callApi('get', 'app/get_product'),
                this.callApi('get', 'app/get_brand'),
                this.callApi('get', 'app/get_category'),
                this.callApi('get', 'app/get_supplier')
            ]);
            if (res.status == 200) {
                this.productLists = res.data
            } else {
                this.swr();
            }
            if (resBrand.status == 200) {
                this.brands = resBrand.data
            } else {
                this.swr();
            }
            if (resCat.status == 200) {
                this.categories = resCat.data
            } else {
                this.swr();
            }
            if (resSuppier.status == 200) {
                this.suppliers = resSuppier.data
            } else {
                this.swr();
            }
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
