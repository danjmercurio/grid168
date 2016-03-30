class AddHoursToOffer < ActiveRecord::Migration
  def change
    add_column :offers, :weekly_hours, :float
    add_column :offers, :monthly_hours, :float
    add_column :offers, :yearly_hours, :float
  end
end
