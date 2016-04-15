class AddTotalHomesToOffer < ActiveRecord::Migration
  def change
    add_column :offers, :total_homes, :integer
  end
end
