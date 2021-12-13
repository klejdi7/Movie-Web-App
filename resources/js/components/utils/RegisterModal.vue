<template>

    <div>

    <a data-bs-toggle="modal" href="#" class="text-dark nav-link" disabled data-bs-target="#regModal" >
	
		Register

  	</a>

  		<div class="modal fade " id="regModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			
			<div class="modal-dialog">
	  			
				<div class="modal-content">
					
					<div class="modal-header">
		 	 			
						<h5 class="modal-title" id="exampleModalLabel">Register</h5>
		  				
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="success=false"></button>
					
					</div>

					<div class="modal-body">

		  					<div class="alert alert-success d-flex align-items-center" role="alert" v-if="success">
								User created successfully!
								Please log in now.
							</div>


							<div class="alert alert-danger d-flex align-items-center" role="alert" v-if="errors !== null" v-for="error in errors">
								{{error}} 
							</div>


						  	<div>
							
								<form>
									
									<div class="row mb-3">
																					
										<div class="input-group mb-3">
  										
										  	<span class="input-group-text" id="basic-addon1">Name</span>
  							
							  				<input type="text" class="form-control" v-model="user.name" placeholder="Enter Name please" name="name" aria-label="name" aria-describedby="basic-addon1">
										
										</div>
									
									</div>

									<div class="row mb-3">
																					
										<div class="input-group mb-3">
  										
										  	<span class="input-group-text" id="basic-addon1">Username</span>
  							
							  				<input type="text" class="form-control" v-model="user.username" placeholder="Enter Username please" name="name" aria-label="name" aria-describedby="basic-addon1">
										
										</div>
									
									</div>

									<div class="row mb-3">
																					
										<div class="input-group mb-3">
  										
										  	<span class="input-group-text" id="basic-addon1">Email</span>
  							
							  				<input type="email" class="form-control" v-model="user.email" placeholder="Email please" name="email" aria-label="Username" aria-describedby="basic-addon1">
										
										</div>
									
									</div>

  									<div class="row mb-3">
    								
										<div class="input-group mb-3">
  										
										  	<span class="input-group-text" id="basic-addon1">Password</span>
  							
							  				<input type="password" class="form-control" v-model="user.psw" placeholder="Enter Password please" name="psw"  aria-label="Username" aria-describedby="basic-addon1">
										
										</div>
					
									</div>

								</form>

							</div>

						</div>
						
					<div class="modal-footer">
		  
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="success = false" >Close</button>
		  
		  				<button type="button" class="btn btn-primary" @click="registerUser()">Register</button>
		
					</div>
	  			
				</div>
	
			</div>

		</div>

  </div>
</template>

<script>

export default {

    data() {
        return {
		user: {},
		success: false,
		errors: null,
        }
    },

	mounted : function(){ },

	watch: {},

    methods: {

        registerUser: function() {

			this.axios.post('/data/register', this.user).then(response => {     
					this.errors = null;
					this.success = true;
				})

				.catch(e => {
					this.errors = e.response.data;
			});           
		}
	},
}

</script>