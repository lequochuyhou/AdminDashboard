<template>
    <div>
        <div class="content">
            <div class="container-fluid">

                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Role management
                        <Button @click="addModal=true">
                            <Icon type="md-add"/>
                            Add new role
                        </Button>
                    </p>

                    <div class="_overflow _table_div">
                        <editor
                            ref="editor"
                            autofocus
                            holder-id="codex-editor"
                            save-button-id="save-button"
                            :init-data="initData"
                            @save="onSave"

                        />


                        <Button @click="save">Save the data</Button>
                    </div>

                </div>
                <Page :total="100"/>

            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                config: {
                    image: {
                        // Like in https://github.com/editor-js/image#config-params
                        endpoints: {

                        },
                        field: 'image',
                        types: 'image/*',
                    }
                },
                initData:null,
                data: {

                }

            }
        },
        methods:
            {
                async add() {
                    if (this.data.roleName.trim() == '') {
                        return this.e('Role name is required');
                    }

                    const res = await this.callApi('post', 'app/create_role', this.data);
                    this.data.roleName = '';
                    if (res.status === 201) {
                        this.roles.unshift(res.data);
                        this.s('Role has been added successfully!');
                        this.addModal = false;
                    } else {
                        if (res.status == 422) {
                            if (res.data.errors.roleName) {
                                this.e(res.data.errors.roleName[0]);
                            }
                        } else {
                            this.swr();
                        }

                    }
                },
                onSave(response){
                    console.log('response on save ',response)
                },
                async  save(){

                    console.log('res is this ',this.$refs.editor.save())
                }
            }
        ,


    }
</script>
