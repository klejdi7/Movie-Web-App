<template>

<div>

	<div class="card mx-auto w-100 mt-2 bg-primary border-0 text-white mb-3">

		<div class="card-body">

			<h4 class="card-title mb-2"> User Details </h4>

			<div class="rounded bg-light text-dark p-2 mb-1">

				<h5>Name: {{ user.name }}</h5>

			</div>

			<div class="rounded bg-light text-dark p-2 mb-1">

				<h5>Username: {{ user.username }}</h5>

			</div>

			<div class="rounded bg-light text-dark p-2 mb-1">

				<h5>Joined at: {{ moment(user.created_at).format('DD-MM-YYYY') }}</h5>

			</div>

		</div>

	</div>
    
    <div class="container-fluid">

        <h3> {{user.name}}'s Entries</h3>

        <p class="text-left fw-light">Found {{ postsLength}} Movies</p>
		
        <movie-modal v-if="$root.isLoggedin && $root.user.id == id" @callback="fetchPosts"></movie-modal>

        <select class="form-select mt-2 w-25"  v-model="sorting.type" @change="sortItems()" aria-label="Default select example">

            <option selected>Sort by</option>

                <option value="likes">Likes</option>
                
                <option value="hates">Hates</option>

                <option value="created_at">Date</option>

        </select>

        <div class="card mb-1 mt-2 bg-light text-black" v-for="post in posts" >
                
                <div class="card-body">
            
                    <div class="card-title bg-dark text-white p-1 rounded row"><h4 class="text-start col"> {{post.title}}</h4>  <p class="text-end col">Posted {{ moment(post.created_at).format('DD-MM-YYYY') }}</p> </div>

                    <p class="card-text bg-white rounded p-3"> {{post.description}} </p>
                    
                   	<like-hate v-bind:itemID="post.id" :action="'like'" @callback="fetchPosts" v-if="$root.isLoggedin == true && $root.user.id != post.user_id"></like-hate>
                    
                    <div class="d-flex flex-row bd-highlight mb-3 mt-3 ml-1 p-2">

                        <div class="bg-success p-2 bd-highlight rounded text-white " > {{post.likes}} Likes</div>
                        <div class="bg-danger  p-2 bd-highlight rounded text-white " > {{post.hates}} Hates</div>
 
                    </div>

                </div>
            
                <div class="card-footer text-muted" v-if="$root.isLoggedin && $root.user.id == id" >
                        
                        <div class="d-flex bd-highlight mb-3">

                        <h5 class="p-2 bd-highlight"> Options: </h5>

                        <button class="btn btn-danger ms-auto p-2 bd-highlight" @click="deleteItem(post.id)" >

                                <i class="fas fa-trash-alt"></i>

                        </button>  

                        </div>

                </div>

                <div class="card-footer text-muted text-center" v-else >
                     Posted by <router-link :to="'/profile/'+id" tag="a" class="text-decoration-none"> <a href="#"> {{post.user}} </a> </router-link>
                </div>
        </div>

    </div>	
</div>
</template>

<script>
    export default {
    data() {
        return  {
			id: this.$route.params.id,
			user: [],
			moment: this.$root.moment,
			posts: {},
            sorting: {},

        }
	},

	watch: { },
	
	mounted: function() {
		this.fetchUser();
		this.fetchPosts();
	},

    /**
     * Methods
     * 
     * 
     * 
     */

	methods : {

        /**
         * Method for fetching User details based on the parameter given id
         * 
         * 
         * 
         * 
         */
		fetchUser: function() {

            this.axios .get(`/data/getUsername/${this.id}`).then(response => {

                this.user = response.data[0];
                
                });
			},

        /**
         * Fetch all posts related to the user
         * 
         * 
         * 
         * 
         */
		fetchPosts: function() {

            this.axios .get(`/api/userPost/${this.id}`).then(response => {

                this.posts = response.data;
                
                });
			},

        /**
         * Sort all items gotten from the user
         * 
         * 
         * 
         * 
         */

		sortItems: function() {
						
			var sortData = new FormData();
            sortData.append('type', this.sorting.type);
			sortData.append('user_id', this.id);
			
            this.axios .post('/api/sortMovies', sortData).then(response => {

                this.posts = response.data;
                
                });
            },

        /**
         * Delete a movie
         * 
         * 
         * 
         */

        deleteItem: function(id)
        {
                    this.axios.delete(`/api/posts/${id}`).then(response => {                       
                        let i = this.posts.map(data => data.id).indexOf(id);
                        this.posts.splice(i, 1)                    })
                        .catch(e => {
                              this.errors = e.response.data;
                    });   
         },
	},
	computed : {
            postsLength: function() {
                return this.posts.length;
            }
        }

}
</script>