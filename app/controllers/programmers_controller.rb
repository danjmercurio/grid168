class ProgrammersController < ApplicationController
	before_filter :authenticate_user!

	# GET /programmers
	# GET /programmers.json
	def index
		current_user.admin? ? @programmers = Programmer.all : @programmers = current_user.programmers
		current_user.admin? ? @offers = Offer.all : @offers = current_user.offers

		respond_to do |format|
			format.html # index.html.erb
		end
	end

	# GET /programmers/1
	# GET /programmers/1.json
	# noinspection Rails3Deprecated
	def show
		@programmer = Programmer.find(params[:id])
    @offers = @programmer.offers

		respond_to do |format|
			format.html # show.html.erb
		end
	end

	# GET /programmers/new
	# GET /programmers/new.json
	def new
		@programmer = Programmer.new
		@back_url = params[:back_url]

		respond_to do |format|
			format.html # new.html.erb
		end
	end

	# GET /programmers/1/edit
	# noinspection Rails3Deprecated
	def edit
		@programmer = Programmer.find(params[:id])
		@back_url = params[:back_url]
	end

	# POST /programmers
	# POST /programmers.json
	def create
		@programmer = current_user.programmers.new(params[:programmer])

		respond_to do |format|
			if @programmer.save
				path = params[:back_url] || @programmer
				format.html { redirect_to path, notice: 'Programmer was successfully created.' }
			else
				format.html { render :action => 'new' }
			end
		end
	end

	# PUT /programmers/1
	# PUT /programmers/1.json
	# noinspection Rails3Deprecated
	def update
		@programmer = Programmer.find(params[:id])

		respond_to do |format|
			if @programmer.update_attributes(params[:programmer])
				path = params[:back_url] || @programmer
				format.html { redirect_to path, :notice => 'Programmer was successfully updated.' }
			else
				format.html { render :action => 'edit' }
			end
		end
	end

	# DELETE /programmers/1
	# DELETE /programmers/1.json
	# noinspection Rails3Deprecated
	def destroy
		@programmer = Programmer.find(params[:id])
		@programmer.delete

		respond_to do |format|
			format.html { redirect_to programmers_url }
		end
	end
end
