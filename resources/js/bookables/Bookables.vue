<template>
    <div>
        <div v-if="loading">Data is loading....</div>
        <div v-else>  
            <div class="row mb-4" v-for="row in rows" :key="'row' + row">
                <div class="col d-flex align-items-stretch" v-for="(bookable, column) in bookablesInRow(row)" :key="'col' + row + column">
                    <bookable-list-item
                        v-bind="bookable"
                    >
                    </bookable-list-item>
                </div>   
                <div class="col" v-for="p in placeholderInRow(row)" :key="'placeholer' + row + p"></div>
            </div>      
            
        </div>
    </div>
</template>
<script>

import BookableListItem from './BookableListItem';

export default {
    components: {
    BookableListItem: BookableListItem,
    },
    data() {
        return {
            bookables:null,
            loading: false,
            columns: 3
        };
    },
    computed: {
        rows() {
            return this.bookables === null ? 0 : Math.ceil(this.bookables.length / this.columns)
        }
    },
    methods: {
        bookablesInRow (row){
            return this.bookables.slice((row - 1) * this.columns, row * this.columns);
        },
        placeholderInRow(row) {
            return this.columns - this.bookablesInRow(row).length;
        }
    },
    beforeCreate() {
        console.log('Before Create');
    },
    created() {
        this.loading = true;

        const p = new Promise((resolve, reject) => {
            console.log(resolve);
            console.log(reject);
            setTimeout(() => {reject("Hello")                
            }, 300);
        }).then(result => console.log(`Sucsess ${result}`))
        .catch(result => console.log(`Error ${result}`))
        ;
        console.log(p);

        const request = axios
        .get("/api/bookables").then(response => {
        this.bookables = response.data;
        //this.bookables.push({title : 'x', description : 'x'});
        this.loading = false;
        })
        .catch(console.log("Failing"))
        ;
        
    },
    beforeMount() {
        console.log('Before Mount');
    },
    mounted() {
        console.log('Mounted');
    },
    beforeUpdate() {
        console.log('Before Update');
    },
    updated() {
        console.log('Updated');
    },
    beforeDestroy() {
        console.log('Before Destroy');
    },
    destroyed() {
        console.log('Destroyed');
    },
}
</script>