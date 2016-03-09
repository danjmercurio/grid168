class HomeController < ApplicationController
	autocomplete :outlet, :name
	before_filter :authenticate_user!
  
	def index
		if params[:outlet_id].blank?
			if params[:name].blank?
				@users = User.all
				@offers = Offer.all
				if current_user.admin?
					render 'admin'
				end #end admin check
					
			else
				outlet = Outlet.find_by_name params[:name]
				redirect_to outlet_path(outlet) unless outlet.nil?
				render text: "<h1>No result found</h1>", layout: true if outlet.nil?
			end #end check params[:name] blank
		else
			redirect_to outlet_path(params[:outlet_id])
		end #end check params[:outlet_id] blank
	end #end index action

	def all_deals
		@offers = Offer.all
		@sub_channel_offers = SubChannelOffer.all
	end #end all_deals action

	# For autocomplete box only with current user, not search all
	# def get_autocomplete_items(parameters)
	# 	super(parameters).where(:user_id => current_user.id)
	# end
		
end
