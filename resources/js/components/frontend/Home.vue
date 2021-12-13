<template>
<div class="container-fluid">

        <h3> Our last entries </h3>

        <div class="container-fluid">

            <div v-if="postsLength <= 0" class="card  mt-2 bg-primary border-0 text-white mb-3">
            
            <div class="card-body">

                <h3> No movies found </h3>

            </div>

        </div>

        <movie-modal v-if="$root.isLoggedin" @callback="fetchPosts"></movie-modal>

        <div v-if="postsLength > 0">

        <p class="text-left fw-light">Found {{ postsLength }} Movies</p>

        <select class="form-select mt-2 w-25"  v-model="sorting.type" @change="sortItems()" aria-label="Default select example">

            <option selected>Sort by</option>

                <option value="likes">Likes</option>
                
                <option value="hates">Hates</option>

                <option value="created_at">Date</option>

        </select>

        </div>
        <div class="card mb-1 mt-2 bg-light text-black" v-for="post in posts" >
                
                <div class="card-body">
            
                    <div class="card-title bg-dark text-white p-1 rounded row"><h4 class="text-start col"> {{post.title}}</h4>  <p class="text-end col">Posted {{ moment(post.created_at).format('DD-MM-YYYY') }}</p> </div>

                    <p class="card-text bg-white rounded p-3"> {{post.description}} </p>
                    
                   	<like-hate v-bind:itemID="post.id" :action="'like'" @callback="fetchPosts" v-if="$root.isLoggedin == true && $root.user.id != post.user_id"></like-hate>
                    
                    <div class="row mt-3 ml-1 w-50 p-2">

                        <div class="bg-success p-2 col rounded text-white w-25" > {{post.likes}} Likes</div>
                        <div class="bg-danger p-2 col rounded text-white w-25" > {{post.hates}} Hates</div>
                    </div>

                </div>
            
                <div class="card-footer text-muted text-center">
                     Posted by <router-link :to="'profile/'+post.user_id" tag="a" class="text-decoration-none"> <a href="#"> {{post.user}} </a> </router-link>
                </div>
        </div>
    </div>
</div>
</template>
 
<script>
    export default {
        data() {
            return {
                moment: this.$root.moment,
                posts: {},
                sorting: {},
            }
        },

        /**
         * 
         * 
         * 
         * 
         */
        
        watch: {},

        /** 
         * Created lift cycle
         * 
         *
         * 
         */

        created() {
			this.fetchPosts();
		},

        /**
         *  Methods
         * 
         * 
         * 
         */

        methods: {
            /**
             *  Fetch every movie from the database
             * 
             * 
             * 
             * 
             */
            fetchPosts: function() {

            this.axios .get('/api/posts').then(response => {

                this.posts = response.data;
                
                });

            },

            /**
             * Sort movies
             * 
             * 
             * 
             * 
             */
            
            sortItems: function() {

            this.axios .post('/api/sortMovies', this.sorting).then(response => {

                this.posts = response.data;
                
                });
            }

        },

        computed : {
            postsLength: function() {
                return this.posts.length;
            }
        }

    }
</script>