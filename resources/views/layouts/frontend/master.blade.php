<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">
@include('layouts.frontend.head')

<body>

    <div id="app">

        <template>

            <nav class="navbar navbar-expand-lg navbar-light bg-light">

                <div class="container-fluid">

					<router-link tag="a" to="/" class="text-decoration-none"> <a class="navbar-brand fw-bold rounded-end bg-dark p-2 text-white" href="#">MovieWorld</a> </router-link>

						<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						
							<span class="navbar-toggler-icon"></span>
						
						</button>

					<div class="collapse navbar-collapse " id="navbarSupportedContent">
						
						<ul class="navbar-nav me-auto mb-2 mb-lg-0">
							
							<li class="nav-item">
							
								<router-link tag="a" to="/" class="text-decoration-none"> <a class="nav-link active" aria-current="page" href="#">Home</a> </router-link>
							
							</li>

							<li class="nav-item" v-if="$root.isLoggedin">
							
								<router-link tag="a" :to="'/profile/'+$root.user.id" class="text-decoration-none"> <a class="nav-link active" aria-current="page" href="#"> My Profile </a> </router-link>
							
							</li>
						
						</ul>

								<li class="nav-item d-flex" v-if="!this.$root.isLoggedin">
									
									<login-modal></login-modal> 
									
								</li>

								<li class="nav-item nav-link text-dark d-flex" v-if="!this.$root.isLoggedin"> OR </li>

								<li class="nav-item d-flex" v-if="!this.$root.isLoggedin">
									
									<register-modal></register-modal> 
									
								</li>

							<div v-else>

								<li class="nav-item dropdown d-flex">
									
									<a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> {{ Auth::check() ? Auth::user()->username : 0}} </a>
									
									<ul class="dropdown-menu " aria-labelledby="navbarDropdown">
																				
										<li><a class="dropdown-item" href="/logout" >Log out</a></li>
										
									</ul>
								
								</li>

							</div>

					</div>
				
				</div>	
				
            </nav>
		
		<router-view style="padding:20px" > </router-view>

        </template>
	
	</div>

	<script src="{{ asset('js/app.js?'.config('app.key')) }}"></script> 
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>


</html>
