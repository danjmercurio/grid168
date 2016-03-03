class RenameHourColumnOffer < ActiveRecord::Migration
  def change
  	rename_column :offers, :hours, :total_hours
  end

end
