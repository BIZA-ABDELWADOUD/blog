<template>
<div>
    <h6> i am a hook </h6>
    <h3> {{name}} </h3>
    <h6> {{password}} </h6>
    <h6> {{age}} </h6>
    <button @click="change"> modify </button>
</div>

</template>


<script>

export default {
    data() {
        return {
            name : 'biza',
            password : '123456',
            age : 3

        }
    },

    methods : {
        change() {
            this.age = 5
        }
    },
    // beforeCreate() {
    //     alert('before create')
    // },
    // created() {
    //     alert('create')
    // },
    // beforeUpdate() {
    //     alert('before update')
    // },
    // updated() {
    //     alert('updated')
    // }
}
</script>