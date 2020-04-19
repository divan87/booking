import Bookables from './bookables/Bookables';
import Bookable from './bookable/Bookable';
import VueRouter from 'vue-router';
import Review from "./review/Review";

const routes = [
    {
        path:'/',
        component:Bookables,
        name:'Bookables',
    },
    {
        path:'/bookable/:id',
        component:Bookable,
        name:'Bookable',
    },
    {
        path:"/review/:id",
        component:Review,
        name: "review"
    }

];

const router = new VueRouter ({
    mode:'history',
    routes,
});

export default router;