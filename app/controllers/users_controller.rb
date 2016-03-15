class UsersController < ApplicationController
  before_filter :authenticate_user!
  before_filter :admin_only

  def index
    @users = User.all

    respond_to do |format|
      format.html do

      end
    end
  end

  def show
    @user = User.find(params[:id])
  end

  def update
    if params[:user][:password].blank?
      params[:user].delete(:password)
      params[:user].delete(:password_confirmation)
    end

    @user = User.find(params[:id])

    respond_to do |format|
      format.html do
        if @user && @user.update_attributes(params[:user])
          redirect_to '/users'
          flash[:notice] = 'User updated successfully.'
        else
          flash[:error] = 'Error: User could not be updated.'
        end
      end
    end
  end

  def destroy
    @user = User.find(params[:id])
    respond_to do |format|
      format.html do
        if @user && @user.delete
          redirect_to users_url
          flash[:notice] = 'User has been deleted.'
        else
          redirect_to :back
          flash[:error] = 'Error: User was not deleted.'
        end
      end
    end
  end
end
