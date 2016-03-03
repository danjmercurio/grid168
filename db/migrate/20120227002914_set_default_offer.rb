class SetDefaultOffer < ActiveRecord::Migration
  def change
  	change_column :offers, :value_per_subscribe, :float, :null => false, :default => 0
  	change_column :offers, :yearly_offer, :float, :null => false, :default => 0
  	change_column :offers, :monthly_offer, :float, :null => false, :default => 0
  	change_column :offers, :weekly_offer, :float, :null => false, :default => 0
  	change_column :offers, :hourly_rate, :float, :null => false, :default => 0
  	change_column :offers, :hours, :float, :null => false, :default => 0
  end

end
