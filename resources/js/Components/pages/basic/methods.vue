<template>
    <div>
        <h1>The number is {{views}}</h1>
        <button @click="updateCounter(1)">Increase</button>
        <button @click="updateCounter(-1)">Decrease</button>
        <br>
        <br>
        <div v-for="(blog,i) in blogs" :key="i" v-if="blogs.length">
                <h1>{{blog.title}}</h1>
                <p>{{blog.post}}</p>
        </div>

        <br>
        <br>

        <div>
            <h1 v-if="showItem">Show this item if "showItem" is true</h1>
            <h1 v-else>Show this item if "showItem" is false</h1>
        </div>

        <button @click="changeShowItem">
            Change
        </button>

    </div>
</template>

<script>
    export default {
        data(){
            return {
                views:0,
                blogs:[],
                showItem:false
            }
        },
        methods:{
            updateCounter(number){
                this.views+=number;
            },
            changeShowItem(){
              this.showItem = !this.showItem
            }
        },
        created() {
            this.views=100
            let posts=[ {title:'this is blog title 1',post:'This is the blog post',id:1},
                {title:'this is blog title 2',post:'This is the blog post',id:2},
                {title:'this is blog title 3',post:'This is the blog post',id:3},
                {title:'this is blog title 4',post:'This is the blog post',id:4},
                {title:'this is blog title 5',post:'This is the blog post',id:5},
            ]

            this.blogs=posts
        }
    }
</script>
