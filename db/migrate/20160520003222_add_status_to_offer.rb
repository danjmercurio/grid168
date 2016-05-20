class AddStatusToOffer < ActiveRecord::Migration
  def change
    add_column :offers, :status, :text
  end
end
