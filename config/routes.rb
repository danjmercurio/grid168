Grid168::Application.routes.draw do

  get 'zoho/getContacts' => 'zoho#getContacts'

	resources :outlets do
		resources :offers
	end

	resources :offers do
		resources :notes
	end

	resources :programmers

	devise_for :users

  resources :users

	root :to => 'offers#index'

	get 'offers/:id/preview' => 'offers#preview'

  post 'offers/:id/sendWorksheet' => 'offers#sendWorksheet'

  post 'offers/:id/setClosedWon' => 'offers#setClosedWon'

  post 'offers/:id/setClosedLost' => 'offers#setClosedLost'

  get 'zoho/export_potential' => 'zoho#export_potential'

  get '/getDRTV' => 'offers#getDRTV'

  get '/offers/:id/reassign' => 'offers#reassign'
  post '/offers/:id/reassign' => 'offers#reassign'



  # The priority is based upon order of creation:
	# first created -> highest priority.

	# Sample of regular route:
	#   match 'products/:id' => 'catalog#view'
	# Keep in mind you can assign values other than :controller and :action

	# Sample of named route:
	#   match 'products/:id/purchase' => 'catalog#purchase', :as => :purchase
	# This route can be invoked with purchase_url(:id => product.id)

	# Sample resource route (maps HTTP verbs to controller actions automatically):
	#   resources :products

	# Sample resource route with options:
	#   resources :products do
	#     member do
	#       get 'short'
	#       post 'toggle'
	#     end
	#
	#     collection do
	#       get 'sold'
	#     end
	#   end

	# Sample resource route with sub-resources:
	#   resources :products do
	#     resources :comments, :sales
	#     resource :seller
	#   end

	# Sample resource route with more complex sub-resources
	#   resources :products do
	#     resources :comments
	#     resources :sales do
	#       get 'recent', :on => :collection
	#     end
	#   end

	# Sample resource route within a namespace:
	#   namespace :admin do
	#     # Directs /admin/products/* to Admin::ProductsController
	#     # (app/controllers/admin/products_controller.rb)
	#     resources :products
	#   end

	# You can have the root of your site routed with "root"
	# just remember to delete public/index.html.
	# root :to => 'welcome#index'

	# See how all your routes lay out with "rake routes"

	# This is a legacy wild controller route that's not recommended for RESTful applications.
	# Note: This route will make all actions in every controller accessible via GET requests.
	# match ':controller(/:action(/:id(.:format)))'

  # HTTP Errors
  %w( 404 422 500 ).each do |code|
    get code, :to => 'errors#show', :code => code
  end

end
