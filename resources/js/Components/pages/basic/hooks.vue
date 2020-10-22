<template>
    <div>
        <h1 ref="myref">This  is  Hooks</h1>
        <h1>My name is {{name}}</h1>
    </div>
</template>


<script>
    export default {
        data(){
            return {
                name:'sadek'
            }
        },
        created() {
          //call mostly initial data from it...
          //   console.log();
        },
        mounted() {
        }
    }
</script>
