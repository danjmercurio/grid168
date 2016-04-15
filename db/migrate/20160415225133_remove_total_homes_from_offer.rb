class RemoveTotalHomesFromOffer < ActiveRecord::Migration
  def change
    remove_column :offers, :total_homes
  end
end
