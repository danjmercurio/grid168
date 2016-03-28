class OffersController < ApplicationController
	before_action :authenticate_user!

	def new
		@outlet = Outlet.find(params[:outlet_id])
		@offer = @outlet.offers.build
		@values = Offervalue.all
		@programmers = current_user.programmers
	end

	def index
		if current_user.admin?
			@offers = Offer.all
		else
			@offers = current_user.offers
		end

	end

	def show
		@offer = Offer.find(params[:id])
				@outlet = @offer.outlet

		@values = Offervalue.all
		@programmers = @offer.programmers
	end #end show action

	def edit
		@offer = Offer.find(params[:id])
		@outlet = Outlet.find(@offer.outlet.id)
		@values = Offervalue.all
		@programmers = @offer.user.programmers
		@url = params[:url]
	end #end edit action

	def update
		@outlet = Outlet.find(params[:outlet_id])
		@offer = Offer.find(params[:id])

		@offer.half_hour_clicked = process_cell_clicked params[:cell]


	    respond_to do |format|
	    	if @offer.update_attributes(params[:offer])
	        	path = params[:url].eql?("homepage") ? root_path : @outlet
	        	format.html { redirect_to path, notice: "Offer was successfully updated" }
	    	else
	      		@values = Offervalue.all
				@programmers = @offer.user.programmers
	        	format.html { render :edit }
	    	end
	    end
	end	 #end update action

	def create

		puts "\nCreate action, OffersController\n"
		@outlet = Outlet.find(params[:outlet_id])
		@offer = @outlet.offers.build(params[:offer].merge({:user_id => current_user.id}))

		@offer.half_hour_clicked = process_cell_clicked params[:cell]

		respond_to do |format|
	    if @offer.save
      	# format.html { redirect_to programmer_path(:id => @offer.programmer_id), :notice => 'Offer was successfully created.' }
    		format.html { redirect_to @outlet, notice: "Offer was created successfully" }
    	else
      	@values = Offervalue.all
				@programmers = current_user.programmers
      	format.html { render :new }
      end
		end #end respond_to
	end #end create action

	def destroy
		# @outlet = Outlet.find(params[:outlet_id])
		@offer = Offer.find(params[:id])
		@offer.destroy

		respond_to do |format|
		    format.html { redirect_to :back }
		    format.js { render :nothing => true }
	    end
	end #end destroy action

	def calculate

		respond_to do |format|
			format.js
		end
	end #end calculate action

	def reset

		respond_to do |format|
			format.js
		end
	end #end reset action

	def process_cell_clicked(cell_arr)
		str = ""
		params[:cell].each do |k, v|
			if v.eql?("1")
				str += k + ";"
			end #end if clicked cell
		end #end cell_arr iterator
		str = str.chomp(';')
	end #end process_cell_clicked method

end
