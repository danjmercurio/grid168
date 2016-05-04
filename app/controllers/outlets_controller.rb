class OutletsController < ApplicationController
	before_action :sanitizeParameters, :only => [:create, :update]


	def index
		current_user.admin? ? @outlets = Outlet.all : @outlets = current_user.outlets
	end #end index action

	def show
		@outlet = Outlet.find(params[:id])
		@user_id = @outlet.user_id

	end #end show action

	def new
		@types = OutletType.all
		@outlet = current_user.outlets.build
	end #end new action

	def create
		respond_to do |format|
			if @outlet.save
				format.html { redirect_to outlets_path, :notice => 'Outlet was successfully created.'}
			else
				format.html { render :action => :new }
			end
		end #end respond_to
	end #end create action

	def edit
		@outlet = Outlet.find(params[:id])
		@offer_id = params[:offer_id] || 0
	end #end edit action

	def update
		@outlet = Outlet.find(params[:id])

		respond_to do |format|
      if @outlet.update(params[:outlet])
				format.html { redirect_to @outlet, notice: "Media Outlet #{@outlet.name} was successfully updated." }
      else
        format.html { render :edit, error: @outlet.errors }
      end
    end
	end #end update action

	def destroy
		@outlet =Outlet.find(params[:id])
		@outlet.destroy

		respond_to do |format|
			format.html { redirect_to outlets_path }
		end #end respond_to
	end #end destroy action

end #end Outlets controller
