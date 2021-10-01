<template>
    <div>
        <h3>the counter is equal {{count}}</h3>
        <button @click="change(1)">increase</button>
        <button @click="change(-1)">decrease</button>
        <br>
        <br>
        <div v-for="(blog,i) in blogs" :key="i" v-if="blogs.length">
                <h3>{{blog.title}}</h3>
                <p>{{blog.content}}</p>
        </div>
        <br>
        <br>
        <div>
            <h1 v-if="vari">it is true</h1>
            <h1 v-else>it is false</h1>
        </div>
        <h2>
            list of students
        </h2>
        <div v-for="(student,i) in students" :key="i" v-if="students.length">
            <p>i am {{student.name}}, i am {{student.age}}, my rank is {{student.id}}</p>
        </div>

        <h1 v-if="age>18">you are able to acces this website</h1>
    </div>
    


</template>

<script>
export default {
    data() {
        return {
            count : 10,
            blogs : [
                {title : 'title1', content : 'content1'},
                {title : 'title2', content : 'content2'},
                {title : 'title3', content : 'content3'},
            ],
            vari : false,
            students: [
                {id : 1, name : 'wadoud', age : 11},
                {id : 2, name : 'hamid', age :15},
                {id : 3, name : 'karim', age :16},
                {id : 4, name : 'loubna', age:20},
            ],
            age : 18,

        }
    },
    methods :  {
        change(number) {
            this.count += number
        }
    },

    
}
</script>
