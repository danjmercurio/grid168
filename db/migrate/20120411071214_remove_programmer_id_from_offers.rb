class RemoveProgrammerIdFromOffers < ActiveRecord::Migration
  def up
    remove_column :offers, :programmer_id
  end

  def down
    add_column :offers, :programmer_id, :integer
  end
end
