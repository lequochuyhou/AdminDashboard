import {mapGetters} from 'vuex'

export default {
    data() {
        return {}
    },
    methods: {
        async callApi(method, url, dataObj) {
            try {
                return await axios({
                    method: method,
                    url: url,
                    data: dataObj
                });
            } catch (e) {
                console.log(e)
                return e.response;
            }
        },
        i(desc, title = "Hey") {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },
        s(desc, title = "Great") {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        w(desc, title = "Oops") {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },
        e(desc, title = "Hey") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },
        swr(desc = 'Something went wrong', title = "Sorry") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },
        checkUserPermission(key){
            if(!this.userPermission)
            {
               return true;
            }
            let isPermitted=false;
            for(let d of this.userPermission){
                if(this.$route.name==d.name)
                {
                   if(d[key]){
                       isPermitted=true;
                       break;
                   }else
                   {
                      break;
                   }
                }
               //  console.log(d[key])
            }
            //console.log(this.$route.name)
            return isPermitted;
        }
    },
    computed: {
        ...mapGetters({
            'userPermission':'getUserPermission'
        }),
        isReadPermitted() {
           //console.log('User permission is',this.userPermission);
           // console.log(this.checkUserPermission())

            return this.checkUserPermission('read')

        },
        isWritePermitted() {
            return this.checkUserPermission('write')
        },
        isUpdatePermitted() {
            return this.checkUserPermission('update')
        },
        isDeletePermitted() {
            return this.checkUserPermission('delete')
        },
    }

}
